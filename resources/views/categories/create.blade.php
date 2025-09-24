@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')
@endsection
@section('content')

    <!-- Form START -->
    <form action="/category/" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <h1 class=" fw-bold mb-4 text-dark">CATEGORY ADD FORM </h1>

        <!-- Form Name -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> Category Name </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="category_name" required placeholder="Category Name "
                    minlength="3" value="{{ old('category_name') }}">
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

                <button type="submit" class="btn btn-primary"> Insert Category </button>
                <a href="/category" class="btn btn-danger">cancel</a>
            </div>
        </div>

    </form>
    <!-- Form END -->


@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}