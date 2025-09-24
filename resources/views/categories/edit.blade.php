@extends('home')
@section('js_before')
@include('sweetalert::alert')
@section('header')
@section('sidebarMenu')
@section('content')

    <form action="/category/{{ $category_id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <!-- Title -->
        <h1 class=" fw-bold mb-4 text-dark">CATEGORY EDIT FORM </h1>

        <!-- Form Name -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> Category Name </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="category_name" required placeholder="Category Name "
                    minlength="3" value="{{ $category_name }}">
                @if(isset($errors))
                    @if($errors->has('category_name'))
                        <div class="text-danger"> {{ $errors->first('category_name') }}</div>
                    @endif
                @endif
            </div>
        </div>


        <div class="form-group row mb-2">
            <label class="col-sm-2"> </label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary"> Update </button>
                <a href="/category" class="btn btn-danger">cancel</a>
            </div>
        </div>

    </form>
    </div>


@endsection


@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}