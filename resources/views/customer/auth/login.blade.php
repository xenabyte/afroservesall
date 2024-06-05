@extends('customer.layout.auth')

@section('content')
<div class="my-auto">
                                        
    <div>
        <h5 class="text-primary">Welcome Back !</h5>
        <p class="text-muted">Sign in to continue to {{ env('APP_NAME') }}.</p>
    </div>

    <div class="mt-4">
         <!-- Login Form -->
         <form method="POST" action="{{ url('/customer/login') }}">
            @csrf
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
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="float-end">
                            <a href="{{ ('/customer/password/reset') }}" class="text-muted">Forgot password?</a>
                        </div>
                        <div class="input-group auth-pass-inputgroup">
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
                

               <div class="col-md-12">
                <div class="form-check">
                    <input class="form-check-input" name="remember" type="checkbox" id="remember-check">
                    <label class="form-check-label" for="remember-check">
                        Remember me
                    </label>
                </div>
               </div>
                
                <div class="mt-3 d-grid">
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                </div>
            </div>
        </form>

        <div class="mt-5 text-center">
            <p>Don't have an account ? <a href="{{ url('/customer/register') }}" class="fw-medium text-primary"> Signup now </a> </p>
        </div>
    </div>
</div>
@endsection
