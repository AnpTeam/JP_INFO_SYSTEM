@extends('home')

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    @include('sweetalert::alert')

    <!-- .container START  -->
    <div class="container mt-4">
        <!-- .row START -->
        <div class="row">
            <!-- .col-sm-12 START -->
            <div class="col-sm-12">
                <!-- Title -->
                <h3> :: form Update Password :: </h3>

                <!-- Form START (POST) -->
                <form action="/user/reset/{{ $user_id }}" method="post">
                    @csrf
                    @method('put')

                    <!-- Name Form -->
                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> name </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="user_name" disabled placeholder="name"
                                value="{{ $user_name }}">
                        </div>
                    </div>

                    <!-- Email Form -->
                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Email/Username </label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="user_email" disabled placeholder="email"
                                value="{{ $user_email }}" minlength="3">
                        </div>
                    </div>

                    <!-- Password Form -->
                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> New Password </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="user_password" required
                                placeholder="New Password 3 characters">
                            @if(isset($errors))
                                @if($errors->has('user_password'))
                                    <div class="text-danger"> {{ $errors->first('user_password') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Confirm Password Form -->
                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Confirm Password </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="user_password_confirmation" required
                                placeholder="Confirm Password 3characters" min="3">
                            @if(isset($errors))
                                @if($errors->has('user_password_confirmation'))
                                    <div class="text-danger"> {{ $errors->first('user_password_confirmation') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Update & Cancel -->
                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> </label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary"> Update </button>
                            <a href="/user" class="btn btn-danger">cancel</a>
                        </div>
                    </div>
                </form>
                <!-- Form END (POST) -->
            </div>
            <!-- .col-sm-12 END -->
        </div>
        <!-- .row END -->
    </div>
    <!-- .container END  -->

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection