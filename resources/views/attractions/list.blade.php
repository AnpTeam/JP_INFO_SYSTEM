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
            <!-- Title & Add Button -->
            <h2 class="fw-bold mb-3"> Attraction Managements Table
                <a href="/attraction/adding" class="ms-3 btn btn-sm btn-danger"> + Attraction </a>
            </h2>

            <!-- Table for Fetch Data -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                <!-- Table Title -->
                <thead>
                    <tr class="">
                        <th width="5%" class="text-center">No.</th>
                        <th width="5%">Pic</th>
                        <th width="45%">Attractions Name & Detail </th>
                        <th width="15%" class="text-center">Category</th>
                        <th width="15%" class="text-center">City</th>
                        <th width="15%" class="text-center">Like Count</th>
                        <th width="5%" class="text-center">edit</th>
                        <th width="5%" class="text-center">delete</th>
                    </tr>
                </thead>

                <!-- Table Data -->
                <tbody>
                    @foreach($attrs as $row)
                    <tr>
                        <!-- No. -->
                        <td align="center">{{ $loop->iteration }}</td>

                        <!-- Attraction Picture -->
                        <td>
                            <img src="{{ asset('storage/' . $row->attr_thumbnail) }}" width="100">
                        </td>
                        <!-- Attraction Name & Description -->
                        <td>
                            <b>Name: {{ $row->attr_name }}</b> <br>
                            Detail:
                            {{ Str::limit($row->attr_desc, 120, '...') }}
                        </td>

                        <!-- Category Name -->
                        <td align="center">{{ $row->category_name }}</td>

                        <!-- City Name -->
                        <td align="center">{{ $row->city_name }}</td>

                        

                        <!-- Edit Button -->
                        <td align="center">
                            <a href="/attraction/{{ $row->attr_id }}" class="btn btn-warning btn-sm">edit</a>
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
                                onclick="deleteConfirm({{ $row->attr_id }})">delete</button>

                            <!-- Delete Form -->
                            <form id="delete-form-{{ $row->attr_id }}" action="/attraction/remove/{{$row->attr_id}}"
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

    
    <!-- Links -->
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