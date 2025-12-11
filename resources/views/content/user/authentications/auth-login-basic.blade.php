@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login')

@section('vendor-style')

@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')

@endsection

@section('page-script')
@vite([
  'resources/assets/js/pages-auth.js'
])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6">
      <!-- Login -->
      <div class="card">
        <div class="card-body py-8">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-6">
            <a href="{{url('/')}}" class="app-brand-link">
              <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
              <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1">Welcome to {{ config('variables.templateName') }}! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>
          @include('include.error')
          @include('include.flashMessage')

          <form id="formAuthentication" class="mb-3" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input tabindex="1" type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus value="{{ old('email') }}">
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input tabindex="1" type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>

            <div class="my-3">
              <div class="d-flex justify-content-between">
                <div class="form-check mb-0 ms-2">
                  <input tabindex="1" class="form-check-input" type="checkbox" name="remember" id="remember"
                  {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
                <a tabindex="-1" href="{{ route('password.forgot') }}">
                  <p class="mb-0">Forgot Password?</p>
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
@endsection
