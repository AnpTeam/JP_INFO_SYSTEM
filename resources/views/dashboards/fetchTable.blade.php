@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Title -->
            <h2 class="fw-bold mb-3"> Dashboard
            </h2>
        </div>

        <div class="col-md-12">
            <!-- Table Dropdown -->
            <form action="/dashboard/table" method="POST">
                @csrf
                <label for="table" class="mb-2">Select a Table</label>
                <div class="row">
                    <div class="col-sm-4">
                <select name="select_table" id="table" class="form-select p-2">
                    @foreach($tableNames as $table)
                    <option value="{{ $table }}">{{ $table }}</option>
                    @endforeach
                </select>
                    </div>
                    <div class="col-sm-4"><button type="submit" class="btn btn-primary p-2 ">   Fetch Data   </button></div>
                </div>       
            </form>
            </h2>
        </div>
    </div>
</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection