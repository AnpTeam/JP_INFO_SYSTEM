@extends('home')

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    @include('sweetalert::alert')

    <!-- Form START -->
    <form action="/city/" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <h1 class=" fw-bold mb-4 text-dark">CITY ADD FORM </h1>

        <!-- City Name -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> CITY Name </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="city_name" required placeholder="City Name " minlength="3"
                    value="{{ old('city_name') }}">
                @if(isset($errors))
                    @if($errors->has('city_name'))
                        <div class="text-danger"> {{ $errors->first('city_name') }}</div>
                    @endif
                @endif
            </div>
        </div>
        <!-- Category Dropdown -->
        <div class="form-group row mb-2">
            <label class="col-sm-2">Region </label>
            <div class="col-sm-6">
                @csrf
                <select id="role" name="region_id" class="form-select">
                    <!-- Default Value -->
                    <option value="">-- Select Region --</option>
                    <!-- Foreach Category -->
                    @foreach ($regions as $regions)
                        <option value="{{ $regions->region_id }}">{{ $regions->region_name }}</option>
                    @endforeach
                    <!-- Foreach Category End -->
                </select>
                @if(isset($errors))
                    @if($errors->has('region_id'))
                        <div class="text-danger"> {{ $errors->first('region_id') }}</div>
                    @endif
                @endif
            </div>
        </div>


        <!-- Create & Cancel -->
        <div class="form-group row mb-2">
            <label class="col-sm-2"> </label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary"> Insert City </button>
                <a href="/city" class="btn btn-danger">Cancel</a>
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