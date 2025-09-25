@extends('frontendAuth')

@section('showLogin')
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg p-4 rounded-4 position-relative" style="max-width: 420px; width: 100%;">
        
        <!-- Back Button (Top Right) -->
        <a href="/" class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm" 
           style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid fa-xmark text-danger"></i>
        </a>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                 style="width: 60px; height: 60px;">
                <i class="fa-solid fa-user text-danger fs-2"></i>
            </div>
            <h3 class="fw-bold mb-1">Welcome Back</h3>
            <p class="text-muted mb-0">Login with your username or email</p>
        </div>

        <!-- Form -->
        <form action="/login" method="post">
            @csrf

            <!-- Username or Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Username / Email</label>
                <input type="text" class="form-control rounded-3" 
                       name="user_name" required minlength="3"
                       placeholder="Enter your username or email" 
                       value="{{ old('user_name') }}">
                @error('user_name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control rounded-3" 
                       name="user_password" required minlength="3"
                       placeholder="Enter your password">
                @error('user_password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Register -->
            <div class="mb-3 text-center">
                <small class="text-muted">Don’t have an account? 
                    <a href="/register" class="text-decoration-none">Register here</a>
                </small>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-danger px-4 rounded-3">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
