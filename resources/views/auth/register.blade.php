@extends('layouts.guest')

@section('title', trans('messages.register'))

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">@lang('messages.register')</h1>
                        </div>
                        <form class="user" action="{{ route('register') }}" method="post">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                       name="name" placeholder="@lang('messages.name')">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                       name="email" placeholder="@lang('messages.email')">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           name="password" id="exampleInputPassword" placeholder="@lang('messages.password')">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                           name="password_confirmation" id="exampleRepeatPassword"
                                           placeholder="@lang('messages.password_confirmation')">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                @lang('messages.register')
                            </button>
                        </form>
                        <div class="text-center">
                            <a class="small" href="{{ route('login-form') }}">@lang('messages.login')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
