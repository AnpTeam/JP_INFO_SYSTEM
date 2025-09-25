@extends('frontend')
@section('css_before')
@section('navbar')
@endsection

@section('imgSlide')
<!-- Hero Carousel Section -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">

        @foreach($attrs as $attr)
        <!-- Slide Coraousel -->
        <div class="carousel-item active">
            <div class="hero d-flex align-items-center"
                style="background-image: url('{{ asset('storage/' . $attr->attr_thumbnail) }}');background-color: rgba(0, 0, 0, 0.14); background-blend-mode: darken;">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <h1 class="fw-bold">Find Nearby Attraction ?</h1>
                    <p class="mb-4">Explore top-rated attractions, activities and more!</p>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <form action="/search/" method="get" class="search-bar d-flex align-items-center">
                                <input type="text" name="keyword" class="form-control me-2"
                                    placeholder="What you looking for?">
                                >

                                <select class="form-select me-2" name="city">
                                    <option value="" class="disabled"> -- Select City -- </option>

                                    @foreach($citys as $city)
                                    <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                                    @endforeach
                                </select>

                                <select class="form-select me-2" name="region">
                                    <option value="" class="disabled"> -- Select Region -- </option>

                                    @foreach($regions as $region)
                                    <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                    @endforeach
                                </select>
                                 <button id="Submit" class="btn btn-primary px-4">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <!-- Optional Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
@endsection



@section('showAttractions')




    <div class="container mt-2 align-item-center ">

        <div class="row ">
            @foreach($topThree as $attr)
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-4">
                    <a href="/detail/{{ $attr->attr_id }}">
                        <div class="card card-overlay-center">
                            <img src="{{ asset('storage/' . $attr->attr_thumbnail) }}" alt="{{ $attr->attr_name }}" class="card-img">
                            <div class="caption-center">
                                <div class="location-icon">
                                    <i class="fas fa-location-dot"></i>

                                </div>
                                <h4 class="card-title">{{$attr->attr_name}}</h4>

                            </div>
                        </div>
                    </a>

                    <!-- 

                    <div class="card" style="width: 100%;" id="topAttraction">
                        <a href="/detail/">
                            <img src="{{ asset('storage/' . $attr->attr_thumbnail) }}" class="card-img-top" alt="devbanban.com">
                        </a>
                        <a href="/detail/" class="link-offset-2 link-underline link-underline-opacity-0">
                            {{$attr->attr_name}}
                        </a>

                    </div> -->
                </div>
            @endforeach
@endsection

    </div>
</div>


@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}