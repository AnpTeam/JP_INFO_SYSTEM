@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<h3> ::Attractions Managements ::
    <a href="/attraction/adding" class="btn btn-primary btn-sm"> Add Attraction </a>
</h3>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr class="table-info">
            <th width="5%" class="text-center">No.</th>
            <th width="5%">Pic</th>
            <th width="45%">Attractions Name & Detail </th>
            <th width="15%" class="text-center">Category</th>
            <th width="15%" class="text-center">City</th>
            <th width="10%" class="text-center">Like Count</th>
            <th width="5%" class="text-center">edit</th>
            <th width="5%" class="text-center">delete</th>
        </tr>
    </thead>

    <tbody>
        @foreach($attrs as $row)
        <tr>
            <td align="center">{{ $row->attr_id }}</td>
            <td>

                <img src="{{ asset('storage/' . $row->attr_thumbnail) }}" width="100">
            </td>
            <td>
                <b>Name: {{ $row->attr_name }}</b> <br>
                Detail:
                {{ Str::limit($row->attr_desc, 120, '...') }}
            </td>
            <!-- FOREACH CATEGORY -->
            
            <td align="center">{{ $row->category_name }}</td>
            
            <!-- FOREACH CATEGORY END -->

            <!-- FOREACH CITY -->
            
            <td align="center">{{ $row->city_name }}</td>
            
            <!-- FOREACH CITY END -->
            <td align="center">{{ number_format($row->like_count,0) }}</td>
            <td align="center">
                <a href="/attraction/{{ $row->attr_id }}" class="btn btn-warning btn-sm">edit</a>
            </td>
            <td align="center">

                {{-- <form action="/attraction/remove/{{$row->attr_id}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Sure to Delete !!');">delete</button>
                </form> --}}


                <button type="button" class="btn btn-danger btn-sm"
                    onclick="deleteConfirm({{ $row->attr_id }})">delete</button>

                <form id="delete-form-{{ $row->attr_id }}" action="/attraction/remove/{{$row->attr_id}}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('delete')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $attrs->links() }}
</div>
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function deleteConfirm(id) {
    Swal.fire({
        title: 'แน่ใจหรือไม่?',
        text: "คุณต้องการลบข้อมูลนี้จริง ๆ หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // ถ้ากด "ลบเลย" ให้ submit form ที่ซ่อนไว้
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>