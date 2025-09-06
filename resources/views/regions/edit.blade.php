@extends('home')
@section('js_before')
@include('sweetalert::alert')
@section('header')
@section('sidebarMenu')
@section('content')

<h3> :: form Update Region :: </h3>

<form action="/region/{{ $region_id }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <!-- Form Name -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Region Name </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="region_name" required placeholder="Region Name "
                minlength="3" value="{{ $region_name }}">
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
                placeholder="Region Description ">{{ $region_desc }}</textarea>
            @if(isset($errors))
            @if($errors->has('region_desc'))
            <div class="text-danger"> {{ $errors->first('region_desc') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Form Picture -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Pic </label>
        <div class="col-sm-6">
            old img <br>
            <img src="{{ asset('storage/' . $region_thumbnail) }}" width="200px"> <br>
            choose new image <br>
            <input type="file" name="region_thumbnail" placeholder="region_thumbnail" accept="image/*">
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
            <input type="hidden" name="oldImg" value="{{ $region_thumbnail }}">
            <button type="submit" class="btn btn-primary"> Update </button>
            <a href="/region" class="btn btn-danger">cancel</a>
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