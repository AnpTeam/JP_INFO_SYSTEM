@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Title -->
            <h2 class="fw-bold mb-3"> Region Managements Table
                <a href="/region/adding" class="ms-3 btn btn-sm btn-danger"> + Region </a>
            </h2>

            <!-- Table -->
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="">
                        <th width="5%" class="text-center">No.</th>
                        <th width="5%">Pic</th>
                        <th width="55%">Region Name & Detail </th>
                        <th width="10%" class="text-center">edit</th>
                        <th width="10%" class="text-center">delete</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($region as $row)
                    <tr>
                        <td align="center">{{ $row->region_id }}</td>
                        <td>

                            <img src="{{ asset('storage/' . $row->region_thumbnail) }}" width="100">
                        </td>
                        <td>
                            <b>Name: {{ $row->region_name }}</b> <br>
                            Detail:
                            {{ Str::limit($row->region_desc, 120, '...') }}
                        </td>
                        <td align="center">
                            <a href="/region/{{ $row->region_id }}" class="btn btn-warning btn-sm">edit</a>
                        </td>
                        <td align="center">

                            {{-- <form action="/attraction/remove/{{$row->attr_id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Sure to Delete !!');">delete</button>
                            </form> --}}


                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="deleteConfirm({{ $row->region_id }})">delete</button>

                            <form id="delete-form-{{ $row->region_id }}" action="/region/remove/{{$row->region_id}}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
    {{ $region->links() }}
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
        text: "ต้องการลบข้อมูลนี้จริง ๆ หรือไม่",
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