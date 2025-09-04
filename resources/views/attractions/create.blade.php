@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')
@endsection
@section('content')


<!-- Title -->
<h3> :: Form Add Product :: </h3>

<!-- Form START -->
<form action="/attraction/" method="post" enctype="multipart/form-data">
    @csrf

    <!-- Form Name -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Attraction Name </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="attr_name" required placeholder="Attration Name "
                minlength="3" value="{{ old('attr_name') }}">
            @if(isset($errors))
            @if($errors->has('attr_name'))
            <div class="text-danger"> {{ $errors->first('attr_name') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Form Description -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Attraction Description </label>
        <div class="col-sm-7">
            <textarea name="attr_desc" class="form-control" rows="4" required
                placeholder="Attraction Description ">{{ old('attr_desc') }}</textarea>
            @if(isset($errors))
            @if($errors->has('attr_desc'))
            <div class="text-danger"> {{ $errors->first('attr_desc') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Category Dropdown -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Category </label>
        <div class="col-sm-6">
            @csrf
            <select id="role" name="attr_category" class="form-select">
                <option value="tourist">tourist</option>
                <option value="temple">temple</option>
            </select>
            @if(isset($errors))
            @if($errors->has('attr_category'))
            <div class="text-danger"> {{ $errors->first('attr_category') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- City Dropdown -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Category </label>
        <div class="col-sm-6">
            @csrf
            <select id="role" name="city_id" class="form-select">
                <option value=1>Nara</option>
                <option value=2>temple</option>
            </select>
            @if(isset($errors))
            @if($errors->has('city_id'))
            <div class="text-danger"> {{ $errors->first('city_id') }}</div>
            @endif
            @endif
        </div>
    </div>

    <div class="form-group row mb-2">
        <label class="col-sm-2"> Pic </label>
        <div class="col-sm-6">
            <input type="file" name="attr_thumbnail" required placeholder="attr_thumbnail" accept="image/*">
            @if(isset($errors))
            @if($errors->has('attr_thumbnail'))
            <div class="text-danger"> {{ $errors->first('attr_thumbnail') }}</div>
            @endif
            @endif
        </div>
    </div>

    <div class="form-group row mb-2">
        <label class="col-sm-2"> </label>
        <div class="col-sm-5">

            <button type="submit" class="btn btn-primary"> Insert Attraction </button>
            <a href="/product" class="btn btn-danger">cancel</a>
        </div>
    </div>

</form>
<!-- Form END -->
</div>


@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}