<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div>
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p class="text-muted">Sign in to continue to {{ env('APP_NAME') }}.</p>
                    <hr>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ url('/customer/login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email address">
                                <label for="email">Email address</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="float-end">
                                    <a href="{{ ('/customer/password/reset') }}" class="text-muted">Forgot password?</a>
                                </div>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" name="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                </div>
                            </div>
                        </div>
                        

                       <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input"  name="remember" type="checkbox" id="remember-check">
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
                <!-- Add your login form here -->
                <p class="mt-2 text-center">If you don't have an account, <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">register here</a>.</p>
            </div>
        </div>
    </div>
</div>

<!-- Registration Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Registration Form -->
                <div>
                    <h5 class="text-primary">Register account</h5>
                    <p class="text-muted">Get your free {{ env('APP_NAME') }} account now.</p>
                    <hr>
                </div>

                <div class="mt-4">
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
        </div>
    </div>
</div>

<!-- Address Verification Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Delivery Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if(!empty($addresses)) 
                    <h5 class="modal-title">Select Location?</h5>                   
                    <div class="col-md-12 mt-2">
                        <div class="form-floating mb-3">
                            <select name="address" class="form-select" id="addressId" aria-label="Select Delivery Address">
                                <option value="" selected>Select Address</option>
                                @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->address_1 .' '. $address->address_2 }}</option>
                                @endforeach
                            </select>
                            <label for="address">Select Delivery Address</label>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <h5 class="modal-title mt-5">New Location?</h5>
                    <div class="col-md-12 mt-2">
                        <label for="address1">Address Line 1</label>
                        <textarea class="form-control mb-3" id="address1" name="address_1" placeholder="Address"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="address1">Address Line 2</label>
                        <textarea class="form-control mb-3" id="address2" name="address_2" placeholder="Major Landmark"></textarea>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number">
                    <label for="phone">Phone Number</label>
                </div>

                <button type="button" class="btn btn-primary" id="makePaymentBtn">Proceed To Payment</button>
            </div>
        </div>
    </div>
</div>

