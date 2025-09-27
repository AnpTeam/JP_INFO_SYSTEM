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
            <h2 class="fw-bold mb-3"> Category Managements Table
                <a href="/category/adding" class="ms-3 btn btn-sm btn-danger"> + Category </a>
            </h2>

            <!-- Table -->
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="">
                        <th width="5%" class="text-center">No.</th>
                        <th width="55%">Category Name  </th>
                        <th width="10%" class="text-center">edit</th>
                        <th width="10%" class="text-center">delete</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($category as $row)
                    <tr>
                        <td align="center">{{ $row->category_id }}</td>

                        <td>
                            {{ $row->category_name }}<br>
                        </td>
                        <td align="center">
                            <a href="/category/{{ $row->category_id }}" class="btn btn-warning btn-sm">edit</a>
                        </td>
                        <td align="center">

                            {{-- <form action="/attraction/remove/{{$row->attr_id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Sure to Delete !!');">delete</button>
                            </form> --}}


                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="deleteConfirm({{ $row->category_id }})">delete</button>

                            <form id="delete-form-{{ $row->category_id }}" action="/category/remove/{{$row->category_id}}"
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
    {{ $category->links() }}
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