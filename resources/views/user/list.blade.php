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
            <h1>User data
                <a href="/user/adding" class="btn btn-primary btn-sm mb-2"> + User </a>
            </h1>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="table-info">
                        <th width="5%" class="text-center">No.</th>
                        <th width="15%"> Name</th>
                        <th width="20%">Email/Username</th>
                        <th width="10%">Phone</th>
                        <th width="5%">Role</th>
                        <th width="5%">edit</th>
                        <th width="5%">PWD</th>
                        <th width="5%">delete</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($UserList as $row)
                    <tr>
                        <td align="center"> {{ $loop->iteration }}. </td>
                        <td>{{ $row->user_name }} </td>
                        <td>{{ $row->user_email }} </td>
                        <td>{{ $row->user_phone }} </td>
                        <td>{{ $row->user_role }} </td>
                        <td>
                            <a href="/user/{{ $row->user_id }}" class="btn btn-warning btn-sm">edit</a>
                        </td>

                        <td>
                            <a href="/user/reset/{{ $row->user_id }}" class="btn btn-info btn-sm">reset</a>
                        </td>
                        <td>
                            {{-- <form action="/user/remove/{{$row->user_id}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">delete</button>
                            </form> --}}

                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="deleteConfirm({{ $row->user_id }})">delete</button>
                            <form id="delete-form-{{ $row->user_id }}" action="/user/remove/{{$row->user_id}}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>


                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <div>
                {{ $UserList->links() }}
            </div>

        </div>
    </div>
</div>
{{-- devbanban.com  --}}

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
        title: 'คุณแน่ใจหรือไม่?',
        text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>