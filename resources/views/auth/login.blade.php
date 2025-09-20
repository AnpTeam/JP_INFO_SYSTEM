@extends('frontendAuth')
@section('css_before')
@section('navbar')
@endsection

@section('showProduct')


<div class="container mt-4">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-6">

            <h3> :: form Login :: </h3>


            <form action="/login" method="post">
                @csrf



                <div class="form-group row mb-2">
                    
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="user_name" required placeholder="email/username"
                            minlength="3" value="{{ old('user_name') }}">
                        @if(isset($errors))
                        @if($errors->has('user_name'))
                        <div class="text-danger"> {{ $errors->first('user_name') }}</div>
                        @endif
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-2">
                    
                    <div class="col-sm-7">
                        <input type="password" class="form-control" name="user_password" required placeholder="Password"
                            minlength="3">
                        @if(isset($errors))
                        @if($errors->has('user_password'))
                        <div class="text-danger"> {{ $errors->first('user_password') }}</div>
                        @endif
                        @endif
                    </div>
                </div>

               
 

                <div class="form-group row mb-2">
                    
                    <div class="col-sm-5">

                        <button type="submit" class="btn btn-primary"> Login </button>
                        <a href="/" class="btn btn-danger">cancel</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}