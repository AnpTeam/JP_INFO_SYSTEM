@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    <!-- Form START  -->
    <form action="/user/{{ $user_id }}" method="post">
        @csrf
        @method('put')

        <!-- Title -->
        <h1 class=" fw-bold mb-4 text-dark">USER EDIT FORM </h1>

        <!-- Name Form -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> Name - Surname </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="user_name" required placeholder="Name" minlength="3"
                    value="{{ $user_name }}">
                @if(isset($errors))
                    @if($errors->has('user_name'))
                        <div class="text-danger"> {{ $errors->first('user_name') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Email Form -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> Email </label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="user_email" required placeholder="Email" minlength="3"
                    value="{{ $user_email }}">
                @if(isset($errors))
                    @if($errors->has('user_email'))
                        <div class="text-danger"> {{ $errors->first('user_email') }}</div>
                    @endif
                @endif
            </div>
        </div>


        <!-- Phone Form -->
        <div class="form-group row mb-3">
            <label class="col-sm-2"> Phone </label>
            <div class="col-sm-6">
                <input type="tel" class="form-control" name="user_phone" required placeholder="Phone 10 digit" minlength="3"
                    maxlength="10" value="{{ $user_phone }}">
                @if(isset($errors))
                    @if($errors->has('user_phone'))
                        <div class="text-danger"> {{ $errors->first('user_phone') }}</div>
                    @endif
                @endif
            </div>
        </div>
        <!-- Role Dropdown -->
        <div class="form-group row mb-3">
            <label class="col-sm-2">Role </label>
            <div class="col-sm-6">
                @csrf
                <select id="role" name="user_role" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                @if(isset($errors))
                    @if($errors->has('admin_role'))
                        <div class="text-danger"> {{ $errors->first('admin_role') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Update & Cancel  -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> </label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary"> Update </button>
                <a href="/user" class="btn btn-danger">cancel</a>
            </div>
        </div>
    </form>

    
    <!-- Form END  -->

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection