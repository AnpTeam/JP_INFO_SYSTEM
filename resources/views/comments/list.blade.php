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
            <h2 class="fw-bold mb-3"> Comments Managements Table
                <a href="/comment/adding" class="ms-3 btn btn-sm btn-danger"> + Comment </a>
            </h2>

            <table class="table table-bordered table-striped table-hover ">
                <thead>
                    <tr class="">
                        <th width="5%" class="text-center">No.</th>
                        <th width="15%" class="text-center">Attraction</th>
                        <th width="15%" class="text-center">Username</th>
                        <th width="40%">Comment Detail </th>
                        <th width="15%" class="text-center">Like Count</th>
                        <th width="5%" class="text-center">edit</th>
                        <th width="5%" class="text-center">delete</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($comments as $row)
                    <tr>
                        <td align="center">{{ $loop->iteration }}</td>
                        <td align="leftr">{{ $row->attr_name }}</td>
                        <td align="left">{{ $row->user_name }}</td>
                        <td align="left">
                            {{ Str::limit($row->comment_desc, 120, '...') }}
                        </td>
                        <td align="right">{{ number_format($row->like_count,0) }}</td>
                        <td align="center">
                            <a href="/comment/{{ $row->comment_id }}" class="btn btn-warning btn-sm">edit</a>
                        </td>
                        <td align="center">

                            {{-- <form action="/comments/remove/{{$row->comment_id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Sure to Delete !!');">delete</button>
                            </form> --}}


                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="deleteConfirm({{ $row->comment_id }})">delete</button>

                            <form id="delete-form-{{ $row->comment_id }}" action="/comment/remove/{{$row->comment_id}}"
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
    
    <div>
        {{ $comments->links() }}
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