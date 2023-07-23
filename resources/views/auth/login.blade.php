@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card login">
          <div class="card-body login">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{url('/')}}" class="app-brand-link gap-2" style="margin-left:35%;">
                <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
                <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2" style="margin-left:20%;">Welcome to {{config('variables.templateName')}}! 👋</h4>
            <p class="mb-4" style="margin-left:8%;">Please sign-in to your account and start the adventure</p>
  
            <form class="mx-1 mx-md-4" action="{{ route('user.login') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email or Username</label>
                <input type="text" name="email" class="form-control" id="email" name="email-username" value="{{ old('email') }}" placeholder="Enter your email or username" autofocus>
                @error('email')
                  <div style="color: red">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  {{-- <a href="{{url('auth/forgot-password-basic')}}">
                    <small>Forgot Password?</small>
                  </a> --}}
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" name="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                @error('password')
                  <div style="color: red">{{ $message }}</div>
                @enderror
              </div>
              {{-- <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me">
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
              </div> --}}
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>
  
            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{url('register')}}">
                <span>Create an account</span>
              </a>
            </p>
          </div>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
  </div>
@endsection
@section('script')

<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/swiper.init.js') }}"></script>

@endsection
