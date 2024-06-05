@extends('customer.layout.auth')

<!-- Main Content -->
@section('content')
<div class="my-auto">
                                        
    <div>
        <h5 class="text-primary">Reset Password !</h5>
        <p class="text-muted">Reset password to continue to {{ env('APP_NAME') }}.</p>
    </div>

    <div class="mt-4">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
         <!-- Login Form -->
         <form method="POST" action="{{ url('/customer/password/email') }}">
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
                
                
                <div class="mt-3 d-grid">
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Send Password Reset Link</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
