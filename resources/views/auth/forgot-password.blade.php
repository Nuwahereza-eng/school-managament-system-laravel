@extends('layouts.auth_app')
@section('content')
<div class="auth-form-transparent text-left p-3">
    <div class="brand-logo text-center mb-4">
        <span style="color: #248afd; font-weight: bold; font-size: 2rem;">SMS</span>
    </div>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <h4>Forgot Password?</h4>
    <h6 class="font-weight-light mb-4">Enter your email to reset your password</h6>
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                    <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-email text-primary"></i>
                    </span>
                </div>
                <input type="email" name="email" class="form-control form-control-lg border-left-0" 
                       id="email" required autofocus placeholder="Enter your email" value="{{ old('email') }}">
            </div>
        </div>
        
        <div class="my-3">
            <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">
                Send Reset Link
            </button>
        </div>
        
        <div class="text-center mt-4 font-weight-light">
            <a href="{{ route('login') }}" class="text-primary">Back to Login</a>
        </div>
    </form>
</div>
@endsection
