@extends('auth.layout')

@section('title', 'Register')

@section('card_body')
    <div class="card-body">

        <div class="text-center mt-4">
            <div class="mb-3">
                <a href="index.html" class="auth-logo">
                    <img src="assets/images/logo-dark.png" height="30" class="logo-dark mx-auto" alt="">
                    <img src="assets/images/logo-light.png" height="30" class="logo-light mx-auto" alt="">
                </a>
            </div>
        </div>

        <h4 class="text-muted text-center font-size-18"><b>Register</b></h4>

        <div class="p-3">
            <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group mb-3 row">
                    <div class="col-12">
                        <input class="form-control" type="text" required="" placeholder="Name" name="name">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <div class="col-12">
                        <input class="form-control" type="email" required="" placeholder="Email" name="email">
                    </div>
                </div>


                <div class="form-group mb-3 row">
                    <div class="col-12">
                        <input class="form-control" type="password" required="" placeholder="Password" name="password">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <div class="col-12">
                        <input class="form-control" type="password" required="" placeholder="Password"
                            name="password_confirmation">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="form-label ms-1 fw-normal" for="customCheck1">I accept <a href="#"
                                    class="text-muted">Terms and Conditions</a></label>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center row mt-3 pt-1">
                    <div class="col-12">
                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Register</button>
                    </div>
                </div>

                <div class="form-group mt-2 mb-0 row">
                    <div class="col-12 mt-3 text-center">
                        <a href="pages-login.html" class="text-muted">Already have account?</a>
                    </div>
                </div>
            </form>
            <!-- end form -->
        </div>
    </div>
@endsection
