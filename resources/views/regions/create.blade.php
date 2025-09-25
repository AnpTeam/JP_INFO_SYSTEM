@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')
@endsection
@section('content')

    <!-- Form START -->
    <form action="/region/" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <h1 class=" fw-bold mb-4 text-dark">REGION ADD FORM </h1>

        <!-- Form Name -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> Region Name </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="region_name" required placeholder="Region Name " minlength="3"
                    value="{{ old('region_name') }}">
                @if(isset($errors))
                    @if($errors->has('region_name'))
                        <div class="text-danger"> {{ $errors->first('region_name') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Form Description -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> Region Description </label>
            <div class="col-sm-7">
                <textarea name="region_desc" class="form-control" rows="4" required
                    placeholder="Region Description ">{{ old('region_desc') }}</textarea>
                @if(isset($errors))
                    @if($errors->has('region_desc'))
                        <div class="text-danger"> {{ $errors->first('region_desc') }}</div>
                    @endif
                @endif
            </div>
        </div>


        <div class="form-group row mb-3">
            <label class="col-sm-2"> Pic </label>
            <div class="col-sm-6">
                <input type="file" name="region_thumbnail" required placeholder="region_thumbnail" accept="image/*">
                @if(isset($errors))
                    @if($errors->has('region_thumbnail'))
                        <div class="text-danger"> {{ $errors->first('region_thumbnail') }}</div>
                    @endif
                @endif
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2"> </label>
            <div class="col-sm-5">

                <button type="submit" class="btn btn-primary"> Insert Region </button>
                <a href="/region" class="btn btn-danger">cancel</a>
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