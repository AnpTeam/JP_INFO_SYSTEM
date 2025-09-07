@extends('home')
@section('js_before')
@include('sweetalert::alert')
@section('header')
@section('sidebarMenu')
@section('content')

<h3> :: form Update Attraction :: </h3>

<form action="/comment/{{ $id }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <!-- User Dropdown -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">User Name </label>
        <div class="col-sm-6">
            @csrf
            <select id="role" name="user_id" class="form-select" >
                <option value="">-- Select User --</option>
                <!-- Foreach User -->
                @foreach ($users as $user)
                <option value="{{ $user->user_id }}" 
            {{ ($comment_user_id == $user->user_id) ? 'selected' : '' }}>
            {{ $user->user_name }}
        </option>
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
    <div class="form-group row mb-2">
        <label class="col-sm-2"> Comment Description </label>
        <div class="col-sm-7">
            <textarea name="comment_desc" class="form-control" rows="4" required
                placeholder="Attraction Description ">{{ $comment_desc }}</textarea>
            @if(isset($errors))
            @if($errors->has('comment_desc'))
            <div class="text-danger"> {{ $errors->first('comment_desc') }}</div>
            @endif
            @endif
        </div>
    </div>

    <!-- Attraction Dropdown -->
    <div class="form-group row mb-2">
        <label class="col-sm-2">Attraction </label>
        <div class="col-sm-6">
            @csrf
            <select id="role" name="attr_id" class="form-select">
                <option value="">-- Select Attraction --</option>
                
                <!-- Foreach City -->
                @foreach ($attractions as $attr)
                <option value="{{ $attr->attr_id }}" 
            {{ ($comment_attr_id == $attr->attr_id) ? 'selected' : '' }}>
            {{ $attr->attr_name }}
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

    <!-- Update & Cancel -->
    <div class="form-group row mb-2">
        <label class="col-sm-2"> </label>
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary"> Update </button>
            <a href="/comment" class="btn btn-danger">cancel</a>
        </div>
    </div>
</form>


@endsection


@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}