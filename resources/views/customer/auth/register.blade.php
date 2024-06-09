@extends('customer.layout.auth')

@section('content')
<div class="my-auto">
                                        
    <div>
        <h5 class="text-primary">Welcome !</h5>
        <p class="text-light">Register your with us at {{ env('APP_NAME') }}.</p>
    </div>

    <div class="mt-4">
         <!-- Login Form -->
         <form method="POST" action="{{ url('/customer/register') }}">
            @csrf
            <div class="mb-3">
                <label for="useremail" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter email" required>  
                <div class="invalid-feedback">
                    Please Enter Email
                </div>        
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter Lastname" required>
                        <div class="invalid-feedback">
                            Please Enter Lastname
                        </div>  
                        <label for="lastname" class="form-label">Lastname</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="othernames" class="form-control" id="othernames" placeholder="Enter Other Names" required>
                        <div class="invalid-feedback">
                            Please Enter Other Names
                        </div>
                        <label for="othernames" class="form-label">Othernames</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group auth-pass-inputgroup">
                            <button class="btn btn-light " type="button"><i class="mdi mdi-lock"></i></button>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">                                        
                            <button class="btn btn-light " type="button"><i class="mdi mdi-lock"></i></button>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <button class="btn btn-light " type="button">+44</i></button>
                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number">
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div>
                <p class="mb-0">By registering you agree to the {{ env('APP_NAME') }} <a href="#" class="text-primary">Terms of Use</a></p>
            </div>
            
            <div class="mt-4 d-grid">
                <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
            </div>

        </form>

        <div class="mt-2 text-center">
            <p>Already have an account ?  <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">login here</a> </p>
        </div>
    </div>
</div>
@endsection
