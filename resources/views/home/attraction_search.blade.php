@extends('frontend')
@section('css_before')

@section('showAttractions')
<div class="container">
    <div class="row g-4" style="margin-top: 100px;">
        <h4 class="fw-semibold">
            @if($count == 0)
            Search result <br> <br> <p class="fs-1 fw-bold text-center mt-5" style="color:red;">Not Found....</p>
            @else
            Search result {{ $count}} attraction{{ $count > 1 ? 's' : '' }}
            @endif
        </h4>


        @foreach($attrs as $data)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
            <div class="card shadow-sm border-0 w-100 d-flex flex-column">
                {{-- Image --}}
                <img src="{{ asset('storage/' . $data->attr_thumbnail) }}" class="card-img-top" alt="devbanban.com"
                    style="object-fit: cover; height: 200px;">

                {{-- Body --}}
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">
                        {{ $data->attr_name }}
                    </h5>

                    <p class="card-text text-muted mt-2 " style="flex-grow: 1;"  >
                        {{ \Illuminate\Support\Str::limit($data->attr_desc, 100) }}
                    </p>

                    {{-- Optional button or footer --}}
                    <a href="{{"/detail"}}" class="btn btn-outline-primary mt-3">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
<div class="row mt-3 mb-2">
    <div class="col-12 d-flex justify-content-center">
        {{ $attrs->links() }}
    </div>
</div>



@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}