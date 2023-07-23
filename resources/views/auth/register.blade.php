@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signup')
@endsection
@section('content')

{{-- <section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card mb-0">
                    <div class="row g-0 align-items-center">
                        <div class="col-xxl-5">
                            <div class="card auth-card bg-secondary h-100 border-0 shadow-none d-none d-sm-block mb-0">
                                <div class="card-body py-5 d-flex justify-content-between flex-column h-100">
                                    <div class="text-center">
                                        <h3 class="text-white">Start your journey with us.</h3>
                                        <p class="text-white opacity-75 fs-base">It brings together your tasks, projects, timelines, files and more</p>
                                    </div>

                                    <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                        <div class="effect-circle-1 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="effect-circle-2 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                                <div class="effect-circle-3 mx-auto rounded-circle position-relative text-white fs-4xl d-flex align-items-center justify-content-center">
                                                    Welcome to <span class="text-primary ms-1">Steex</span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="auth-user-list list-unstyled">
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="build/images/users/avatar-1.jpg" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="build/images/users/avatar-2.jpg" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="build/images/users/avatar-3.jpg" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="build/images/users/avatar-4.jpg" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="avatar-sm d-inline-block">
                                                    <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                        <img src="build/images/users/avatar-5.jpg" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-white opacity-75 mb-0 mt-3">
                                            &copy;
                                            <script>
                                                document.write(new Date().getFullYear())

                                            </script> Steex. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-6 mx-auto">
                            <div class="card mb-0 border-0 shadow-none mb-0">
                                <div class="card-body p-sm-5 m-lg-4">
                                    <div class="text-center mt-2">
                                        <h5 class="fs-3xl">Create your free account</h5>
                                        <p class="text-muted">Get your free Steex account now</p>
                                    </div>
                                    <div class="p-2 mt-5">
                                        <form class="needs-validation" novalidate method="POST" action="{{ route('user.register') }}" enctype="multipart/form-data">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="useremail" placeholder="Enter email address" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter email
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="username" placeholder="Enter username" required>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter username
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label for="userpassword" class="form-label">Password <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="userpassword" placeholder="Enter password" required>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <div class="invalid-feedback">
                                                    Please enter password
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <p class="mb-0 fs-xs text-muted fst-italic">By registering you agree to the Steex <a href="pages-term-conditions" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                            </div>

                                            <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                <h5 class="fs-sm">Password must contain:</h5>
                                                <p id="pass-length" class="invalid fs-xs mb-2">Minimum <b>8 characters</b></p>
                                                <p id="pass-lower" class="invalid fs-xs mb-2">At <b>lowercase</b> letter (a-z)</p>
                                                <p id="pass-upper" class="invalid fs-xs mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                                <p id="pass-number" class="invalid fs-xs mb-0">A least <b>number</b> (0-9)</p>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <div class="signin-other-title position-relative">
                                                    <h5 class="fs-sm mb-4 title text-muted">Create account with</h5>
                                                </div>

                                                <div>
                                                    <button type="button" class="btn btn-subtle-primary btn-icon "><i class="ri-facebook-fill fs-lg"></i></button>
                                                    <button type="button" class="btn btn-subtle-danger btn-icon "><i class="ri-google-fill fs-lg"></i></button>
                                                    <button type="button" class="btn btn-subtle-dark btn-icon "><i class="ri-github-fill fs-lg"></i></button>
                                                    <button type="button" class="btn btn-subtle-info btn-icon "><i class="ri-twitter-fill fs-lg"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Already have an account ? <a href="auth-signin" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section> --}}
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
  
        <!-- Register Card -->
        <div class="card register">
          <div class="card-body register">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{url('/')}}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
                <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Adventure starts here 🚀</h4>
            <p class="mb-4">Make your app management easy and fun!</p>
  
            <form class="mx-1 mx-md-4" action="{{ route('user.register') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="firstname" value="{{ old('firstname') }}" placeholder="Enter your username" autofocus>
                @error('firstname')
                  <div style="color: red">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                @error('email')
                  <div style="color: red">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                @error('password')
                  <div style="color: red">{{ $message }}</div>
                @enderror
              </div>
  
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Confirm Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                @error('password')
                  <div style="color: red">{{ $message }}</div>
                @enderror
              </div>
  
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                  <label class="form-check-label" for="terms-conditions">
                    I agree to
                    <a href="javascript:void(0);">privacy policy & terms</a>
                  </label>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">
                Sign up
              </button>
            </form>
  
            <p class="text-center">
              <span>Already have an account?</span>
              <a href="{{url('/')}}">
                <span>Sign in instead</span>
              </a>
            </p>
          </div>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
  </div>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/passowrd-create.init.js') }}"></script>
@endsection
