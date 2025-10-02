@extends('home')

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    @include('sweetalert::alert')

    <form action="/region/{{ $region_id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <!-- Title -->
        <h1 class="fw-bold mb-4 text-dark">REGION UPDATE FORM</h1>

        <!-- Form Name -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Region Name</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="region_name" required placeholder="Region Name"
                       minlength="3" value="{{ $region_name }}">
                @error('region_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Description -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Region Description</label>
            <div class="col-sm-7">
                <textarea name="region_desc" class="form-control" rows="4" required
                          placeholder="Region Description">{{ $region_desc }}</textarea>
                @error('region_desc')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Picture -->
        <div class="form-group row mb-3">
            <label class="col-sm-2">Pic</label>
            <div class="col-sm-6">
                <p>Old image:</p>
                <img src="{{ asset('storage/' . $region_thumbnail) }}" width="200px" class="mb-2">
                <p>Choose new image:</p>
                <input type="file" name="region_thumbnail" accept="image/*">
                @error('region_thumbnail')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"></label>
            <div class="col-sm-5">
                <input type="hidden" name="oldImg" value="{{ $region_thumbnail }}">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/region" class="btn btn-danger">Cancel</a>
            </div>
        </div>

    </form>
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}