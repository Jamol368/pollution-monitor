<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Http;

class LokiHandler extends AbstractProcessingHandler
{
    protected string $host;

    /**
     * Accept the Loki host URL (e.g. http://loki:3102).
     */
    public function __construct(string $host, $level = Logger::DEBUG, bool $bubble = true)
    {
        $this->host = $host;
        parent::__construct($level, $bubble);
    }

    /**
     * This method is called by Monolog to push a log record.
     *
     * @param  \Monolog\LogRecord  $record
     */
    protected function write(LogRecord $record): void
    {
        // Use the "formatted" value if a formatter was applied; otherwise, fallback to the message.
        $message = is_string($record->formatted) ? $record->formatted : $record->message;

        // Prepare the payload. Note that the timestamp must be a string in nanoseconds.
        $payload = [
            'streams' => [
                [
                    'stream' => [
                        'app'   => 'laravel',             // You can add extra labels here if desired.
                        'level' => $record->level->getName(),
                    ],
                    'values' => [
                        [
                            (string) (intval(microtime(true) * 1e9)), // Timestamp in nanoseconds.
                            $message,
                        ],
                    ],
                ],
            ],
        ];

        // Send the log to Loki using an HTTP POST request.
        Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("{$this->host}/loki/api/v1/push", $payload);
    }
}

class LokiLogger
{
    /**
     * This method will be called by Laravel when creating the custom logging channel.
     *
     * The $config array is pulled from the logging configuration.
     */
    public function __invoke(array $config)
    {
        // Get the Loki host from the channel config; use a default if not set.
        $host = $config['host'] ?? 'http://loki:3100';

        $logger = new Logger('loki');
        $logger->pushHandler(new LokiHandler($host));

        return $logger;
    }
}
