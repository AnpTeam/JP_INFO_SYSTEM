@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')
@endsection
@section('content')




<!-- Form START -->
<form action="/comment/" method="post" enctype="multipart/form-data" class="p-3">
    @csrf
    <!-- Title -->
    <h1 class=" fw-bold mb-4 text-dark">COMMENT ADD FORM </h1>

    <!-- User Dropdown -->
    <div class="form-group row mb-4">
        <label class="col-sm-12 mb-2">User Name </label>
        <div class="col-sm-12">
            @csrf
            <select id="role" name="user_id" class="form-select" >
                <option value="">-- Select User --</option>
                <!-- Foreach User -->
                @foreach ($users as $user)
                <option value="{{ $user->user_id }}">{{ $user->user_name }}</option>
                @endforeach
                <!-- Foreach User End -->
            </select>
            @if(isset($errors))
            @if($errors->has('user_id'))
            <div class="text-danger"> {{ $errors->first('user_id') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Form Description -->
    <div class="form-group row mb-4">
        <label class="col-sm-12 mb-2"> Comment Description </label>
        <div class="col-sm-12">
            <textarea name="comment_desc" class="form-control" rows="4" required
                placeholder="Attraction Description ">{{ old('comment_desc') }}</textarea>
            @if(isset($errors))
            @if($errors->has('comment_desc'))
            <div class="text-danger"> {{ $errors->first('comment_desc') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Attraction Dropdown -->
    <div class="form-group row mb-4">
        <label class="col-sm-12 mb-2">Attraction </label>
        <div class="col-sm-12">
            @csrf
            <select id="role" name="attr_id" class="form-select">
                <option value="">-- Select Attraction --</option>
                
                <!-- Foreach City -->
                @foreach ($attractions as $attr)
                <option value="{{ $attr->attr_id }}">{{ $attr->attr_name }}</option>
                @endforeach
                <!-- Foreach Attraction End -->
            </select>
            @if(isset($errors))
            @if($errors->has('attr_id'))
            <div class="text-danger"> {{ $errors->first('attr_id') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Insert & Cancel -->
    <div class="form-group row mb-4">
        <label class="col-sm-2 mb-2"> </label>
        <div class="col-sm-12">
            <button type="submit" class="btn btn-outline-primary me-3 p-2"> Insert Comment </button>
            <a href="/comment" class="btn btn-outline-danger p-2">Cancel</a>
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