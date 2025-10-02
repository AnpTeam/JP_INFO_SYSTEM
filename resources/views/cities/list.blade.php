@extends('home')

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    @include('sweetalert::alert')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Title & Add Button -->
                <h2 class="fw-bold mb-3"> City Managements Table
                    <a href="/city/adding" class="ms-3 btn btn-sm btn-danger"> + City </a>
                </h2>

                <!-- Table for Fetch Data -->
                <table class="table table-bordered table-striped table-hover">
                    <!-- Table Title -->
                    <thead>
                        <tr class="">
                            <th width="5%" class="text-center">No.</th>
                            <th width="25%" class="text-center">City Name </th>
                            <th width="25%" class="text-center">Region </th>
                            <th width="5%" class="text-center">edit</th>
                            <th width="5%" class="text-center">delete</th>
                        </tr>
                    </thead>

                    <!-- Table Data -->
                    <tbody>
                        @foreach($cities as $row)
                            <tr>
                                <!-- No. -->
                                <td align="center">{{ $loop->iteration }}</td>

                                <!-- City Name -->
                                <td align="center">
                                    {{ $row->city_name }} <br>
                                </td>

                                <!-- Region Name -->
                                <td align="center">{{ $row->region_name }}</td>


                                <!-- Edit Button -->
                                <td align="center">
                                    <a href="/city/{{ $row->city_id }}" class="btn btn-warning btn-sm">edit</a>
                                </td>

                                <!-- Delete Button -->
                                <td align="center">
                                    {{-- <form action="/attraction/remove/{{$row->attr_id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Sure to Delete !!');">delete</button>
                                    </form> --}}

                                    <!-- Delete Confirm Button -->
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteConfirm({{ $row->city_id }})">delete</button>

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $row->city_id }}" action="/city/remove/{{$row->city_id}}"
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

        <!-- Links -->
        <div>
            {{ $cities->links() }}
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