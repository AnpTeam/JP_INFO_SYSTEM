@extends('frontend')
@section('css_before')

@section('showAttractions')

<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">

        <!-- Slide Coraousel -->
        <div class="carousel-item active">
            <div class="hero d-flex align-items-center"
                style="background-image: url('{{ asset('storage/' . $region_thumbnail) }}');background-color: rgba(0, 0, 0, 0.14); background-blend-mode: darken; background-size: auto;">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <h1 class="fw-bold">{{ \Illuminate\Support\Str::limit($region_name, 100) }}</h1>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container my-5">
    <div class="row align-items-start px-6">
        <!-- ข้อความ -->
        <div class="col-md-6" style="padding-right: 100px;"> <!-- ขยับออกทางซ้าย -->
            <h3>Overview</h3>
            <p>
                {{ \Illuminate\Support\Str::limit($region_desc, 1000) }}
            </p>
        </div>

        <!-- Comment -->
        {{-- <div class="col-md-6" style="padding-left: 100px;"> <!-- ขยับออกทางขวา -->
            <div style="background: linear-gradient(135deg, #ff4b2b, #ff416c); 
                        color: white; 
                        padding: 20px; 
                        border-radius: 15px; 
                        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
                        min-height: 250px;">
                <h4 style="margin-bottom: 15px;"> Comments</h4>
                <div style="background: rgba(255,255,255,0.2); 
                            padding: 10px 15px; 
                            border-radius: 10px; 
                            margin-bottom: 10px;">
                    <b>User1:</b> สวยมาก อยากไปเที่ยว!
                </div>
                <div style="background: rgba(255,255,255,0.2); 
                            padding: 10px 15px; 
                            border-radius: 10px; 
                            margin-bottom: 10px;">
                    <b>User2:</b> วิวกลางคืนคือสุดยอด 
                </div>
                <div style="background: rgba(255,255,255,0.2); 
                            padding: 10px 15px; 
                            border-radius: 10px;">
                    <b>User3:</b> แนะนำเลยครับ!
                </div>
            </div>
        </div> --}}
    </div>
</div>

@endsection

