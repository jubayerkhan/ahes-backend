<div class="service-list-wrapper floatCss">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-11 col-lg-11">
                <div class="subpage-top-content floatCss">
                    <p>At Australian Higher Education Solutions (AHES), we stand out for our unparalleled
                        commitment to guiding students toward success in their higher education journey. Here’s
                        why we are the right partner for your academic aspirations:</p>
                    <p>With AHES, students are not just enrolling in higher education—they’re embarking on a
                        path to a brighter future, backed by our expertise and care. Let us be your guide in
                        this exciting journey!</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($services as $service)
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="service-single floatCss">
                        <div class="service-single-content floatCss same-height">
                            <div class="service-icon floatCss"><span><img src="{{ asset('storage/' . $service->icon) }}" alt="Logo" /></span>
                            </div>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>