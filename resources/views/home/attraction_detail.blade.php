@extends('frontend')
@section('css_before')

@section('showAttractions')

    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">

            <!-- Slide Coraousel -->
            <div class="carousel-item active">
                <div class="hero d-flex align-items-center"
                    style="background-image: url('{{ asset('storage/' . $attr_thumbnail) }}');background-color: rgba(0, 0, 0, 0.14); background-blend-mode: darken; background-size: auto;">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <h1 class="fw-bold">{{ \Illuminate\Support\Str::limit($attr_name, 100) }}</h1>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="container my-5">
        <div class="row align-items-start px-6">
            <!-- ข้อความ -->
            <div class="" style="padding-right: 100px;"> <!-- ขยับออกทางซ้าย -->
                <h3>Overview</h3>
                <p>
                    {{ \Illuminate\Support\Str::limit($attr_desc, 1000) }}
                </p>
                <ul>
                    <li>Category : {{ \Illuminate\Support\Str::limit($category_name, 100) }} </li>
                    <li>City : {{ \Illuminate\Support\Str::limit($city_name, 100) }} </li>
                    <li>Region : {{ \Illuminate\Support\Str::limit($region_name, 100) }} </li>
                </ul>
            </div>

            <!-- Comment -->
            <div>
                <h4 class="mb-4">{{ $commentCount }} Comments</h4>

                <!-- Write Comment -->
                <div class="mb-4">
                    <form action="/addComment" method="POST" id="comment-form">
                        @csrf
                        <input type="hidden" name="attr_id" value="{{ $attr_id }}">
                        <input type="hidden" name="user_id" value="{{ session('user_id') }}">

                        <div class="align-items-start gap-2">
                            <textarea class="form-control" id="comment_desc" name="comment_desc" rows="1"
                                placeholder="Add a comment..." required></textarea>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn border border-0 d-none" id="submit-btn">Comment</button>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Show Comment -->
                @php
                    $charLimit = 100;
                @endphp

                @foreach ($comments as $comment)
                    @php
                        $isLong = strlen($comment->comment_desc) > $charLimit;
                        $shortText = Str::limit($comment->comment_desc, $charLimit, '');
                        $fullText = $comment->comment_desc;
                    @endphp

                    <div class="p-1 mb-4 shadow-sm rounded bg-white">
                        <!-- Header -->
                        <div class="d-flex align-items-center mb-2 gap-3 flex-wrap">
                            <span class="fw-semibold fs-5 text-primary">{{ $comment->user_name }}</span>
                            <span
                                class="text-muted small">{{ \Carbon\Carbon::parse($comment->date_created)->format('M d, Y') }}</span>
                        </div>

                        <!-- Comment Text -->
                        <div class="text-dark lh-base text-break text-justify">
                            @if ($isLong)
                                <span class="short-text">{{ $shortText }}<span class="dots">...</span></span>
                                <span class="full-text d-none">{{ $fullText }}</span>
                                <br>
                                <button class="btn btn-link btn-sm p-0 show-more-btn">Show more</button>
                            @else
                                {{ $comment->comment_desc }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Java Script -->
        <!-- Comment Show More -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.show-more-btn');

                buttons.forEach(button => {
                    button.addEventListener('click', function () {
                        const parent = button.closest('.text-dark');
                        const shortText = parent.querySelector('.short-text');
                        const fullText = parent.querySelector('.full-text');

                        const isHidden = fullText.classList.contains('d-none');

                        if (isHidden) {
                            shortText.classList.add('d-none');
                            fullText.classList.remove('d-none');
                            button.textContent = 'Show less';
                        } else {
                            fullText.classList.add('d-none');
                            shortText.classList.remove('d-none');
                            button.textContent = 'Show more';
                        }
                    });
                });
            });
        </script>

        <!-- Hide Comment Button -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const textarea = document.getElementById('comment_desc');
                const submitBtn = document.getElementById('submit-btn');

                // Ensure button starts hidden and disabled
                submitBtn.classList.add('d-none');
                submitBtn.disabled = true;

                // Show button on focus
                textarea.addEventListener('focus', function () {
                    submitBtn.classList.remove('d-none');
                    checkContent();
                });

                // Enable/disable button based on content
                textarea.addEventListener('input', checkContent);

                // Optional: hide button on blur if empty
                textarea.addEventListener('blur', function () {
                    if (textarea.value.trim() === '') {
                        submitBtn.classList.add('d-none');
                        submitBtn.disabled = true;
                    }
                });

                function checkContent() {
                    const hasText = textarea.value.trim().length > 0;
                    submitBtn.disabled = !hasText;
                }
            });
        </script>
@endsection