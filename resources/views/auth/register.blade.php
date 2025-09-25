@extends('frontendAuth')

@section('showLogin')
<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg p-4 rounded-4 position-relative" style="max-width: 460px; width: 100%;">
        
        <!-- Back Button (Top Right) -->
        <a href="/login" class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm" 
           style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid fa-arrow-left text-danger"></i>
        </a>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                 style="width: 60px; height: 60px;">
                <i class="fa-solid fa-user-plus text-danger fs-2"></i>
            </div>
            <h3 class="fw-bold mb-1">New to Here ?</h3>
            <p class="text-muted mb-0">Register with your details below</p>
        </div>

        <!-- Form -->
        <form action="/register" method="post">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-regular fa-id-card me-1"></i> Name - Surname</label>
                <input type="text" class="form-control rounded-3" 
                       name="user_name" required minlength="3"
                       placeholder="Enter your name" value="{{ old('user_name') }}">
                @error('user_name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-regular fa-envelope me-1"></i> Email</label>
                <input type="email" class="form-control rounded-3" 
                       name="user_email" required
                       placeholder="Enter your email" value="{{ old('user_email') }}">
                @error('user_email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-solid fa-lock me-1"></i> Password</label>
                <input type="password" class="form-control rounded-3" 
                       name="user_password" required minlength="3"
                       placeholder="Enter your password">
                @error('user_password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="fa-solid fa-phone me-1"></i> Phone</label>
                <input type="tel" class="form-control rounded-3" 
                       name="user_phone" required maxlength="10"
                       placeholder="10-digit phone" value="{{ old('user_phone') }}">
                @error('user_phone')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-danger px-4 rounded-3">
                    <i class="fa-solid fa-user-plus me-1"></i> Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
