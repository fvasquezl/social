@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 bg-light px-4 py-4">
                    <h3 class="card-title text-center">Register</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Username') }}</label>
                                <input id="name"
                                       type="text"
                                       class="form-control border-0 @error('name') is-invalid @enderror"
                                       name="name"
                                       value="{{ old('name') }}"
                                       autocomplete="name"
                                       autofocus
                                       placeholder="Your name...">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="first_name">{{ __('First name') }}</label>
                                <input id="first_name"
                                       type="text"
                                       class="form-control border-0 @error('first_name') is-invalid @enderror"
                                       name="first_name"
                                       value="{{ old('first_name') }}"
                                       autocomplete="first_name"
                                       autofocus
                                       placeholder="Your first name...">

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">{{ __('First name') }}</label>
                                <input id="last_name"
                                       type="text"
                                       class="form-control border-0 @error('last_name') is-invalid @enderror"
                                       name="last_name"
                                       value="{{ old('last_name') }}"
                                       autocomplete="last_name"
                                       autofocus
                                       placeholder="Your last name...">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email"
                                       type="email"
                                       class="form-control border-0 @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       autocomplete="email"
                                       autofocus
                                       placeholder="Your email...">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password"
                                       type="password"
                                       class="form-control border-0 @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Your password...">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Password confirmation') }}</label>
                                <input id="password_confirmation"
                                       type="password"
                                       class="form-control border-0"
                                       name="password_confirmation"
                                       placeholder="Your password...">
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-primary  btn-block"
                                        dusk="register-btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
