@extends('customer.layout.auth')

@section('content')
<div class="my-auto">
                                        
    <div>
        <h5 class="text-primary">Reset Password !</h5>
        <p class="text-light">Reset password to continue to {{ env('APP_NAME') }}.</p>
    </div>

    <div class="mt-4">
         <!-- Login Form -->
         <form method="POST" action="{{ url('/customer/password/reset') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}" id="email" placeholder="Enter Email address">
                        <label for="email">Email address</label>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group auth-pass-inputgroup">
                                <button class="btn btn-light " type="button"><i class="mdi mdi-lock"></i></button>
                                <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group">                                        
                                <button class="btn btn-light " type="button"><i class="mdi mdi-lock"></i></button>
                                <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" placeholder="Confirm password">
                            </div>

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                
                <div class="mt-3 d-grid">
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
