@extends('home')
@section('js_before')
@include('sweetalert::alert')
@section('header')
@section('sidebarMenu')
@section('content')

<form action="/attraction/{{ $attr_id }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <!-- Title -->
    <h1 class=" fw-bold mb-4 text-dark">ATTRACTION EDIT FORM </h1>

    <!-- Attraction Name -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Attraction Name </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="attr_name" required placeholder="Attration Name "
                minlength="3" value="{{ $attr_name }}">
            @if(isset($errors))
            @if($errors->has('attr_name'))
            <div class="text-danger"> {{ $errors->first('attr_name') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Attraction Description -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Attraction Description </label>
        <div class="col-sm-7">
            <textarea name="attr_desc" class="form-control" rows="4" required
                placeholder="Attraction Description ">{{ $attr_desc }}</textarea>
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
            <select id="role" name="category_id" class="form-select">
                <!-- Foreach Category -->
                @foreach ($categories as $category)
                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                @endforeach
                <!-- Foreach Category End -->
            </select>
            @if(isset($errors))
            @if($errors->has('category_id'))
            <div class="text-danger"> {{ $errors->first('category_id') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- City Dropdown -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">City </label>
        <div class="col-sm-6">
            @csrf
            <select id="role" name="city_id" class="form-select">
                <!-- Foreach City -->
                @foreach ($citys as $city)
                <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                @endforeach
                <!-- Foreach City End -->
            </select>
            @if(isset($errors))
            @if($errors->has('city_id'))
            <div class="text-danger"> {{ $errors->first('city_id') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Attraction Picture -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Pic </label>
        <div class="col-sm-6">
            old img <br>
            <img src="{{ asset('storage/' . $attr_thumbnail) }}" width="200px"> <br>
            choose new image <br>
            <input type="file" name="attr_thumbnail" placeholder="attr_thumbnail" accept="image/*">
            @if(isset($errors))
            @if($errors->has('attr_thumbnail'))
            <div class="text-danger"> {{ $errors->first('attr_thumbnail') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Update & Cancel -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> </label>
        <div class="col-sm-5">
            <input type="hidden" name="oldImg" value="{{ $attr_thumbnail }}">
            <button type="submit" class="btn btn-primary"> Update </button>
            <a href="/attraction" class="btn btn-danger">Cancel</a>
        </div>
    </div>
</form>


@endsection


@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}