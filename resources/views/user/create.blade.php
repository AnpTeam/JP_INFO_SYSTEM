@extends('home')

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    @include('sweetalert::alert')

    <!-- Form START  -->
    <form action="/user/" method="post" id="myForm">
        @csrf
        <!-- Title -->
        <h1 class=" fw-bold mb-4 text-dark">USER ADD FORM </h1>

        <!-- Name Form -->
        <div class="form-group row mb-2">
            <label class="col-sm-3"> Name - Surname </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="user_name" required placeholder="Name" minlength="3"
                    value="{{ old('user_name') }}">
                @if(isset($errors))
                    @if($errors->has('user_name'))
                        <div class="text-danger"> {{ $errors->first('user_name') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Email Form -->
        <div class="form-group row mb-2">
            <label class="col-sm-3"> Email </label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="user_email" required placeholder="Email" minlength="3"
                    value="{{ old('user_email') }}">
                @if(isset($errors))
                    @if($errors->has('user_email'))
                        <div class="text-danger"> {{ $errors->first('user_email') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Password Form -->
        <div class="form-group row mb-2">
            <label class="col-sm-3"> Password </label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="user_password" required placeholder="Password"
                    minlength="3">
                @if(isset($errors))
                    @if($errors->has('user_password'))
                        <div class="text-danger"> {{ $errors->first('user_password') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Phone Form -->
        <div class="form-group row mb-2">
            <label class="col-sm-3"> Phone </label>
            <div class="col-sm-6">
                <input type="tel" class="form-control" name="user_phone" required placeholder="Phone 10 digit" minlength="3"
                    maxlength="10" value="{{ old('user_phone') }}">
                @if(isset($errors))
                    @if($errors->has('user_phone'))
                        <div class="text-danger"> {{ $errors->first('user_phone') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Role Dropdown -->
        <div class="form-group row mb-3">
            <label class="col-sm-3">Role </label>
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

        <!-- Save & Cancel -->
        <div class="form-group row mb-2">
            <label class="col-sm-3"> </label>
            <div class="col-sm-5">

                <button type="submit" class="btn btn-primary"> Save </button>
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