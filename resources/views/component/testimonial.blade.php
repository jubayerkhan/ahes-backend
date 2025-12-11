<div class="study-australia-section floatCss">
    <div class="container">
        <div class="row alignCenter-content">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="common-image-container" style="background-image:url(images/testimonial-bg.png)">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="testimonial-wrapper floatCss">
                    <div class="testimonial-inner">
                        <div class="testimonial-tittle-section floatCss">
                            <h4>Success Stories</h4>
                            <h2>Testimonials</h2>
                        </div>
                        <div class="testimonial-slider-container floatCss">
                            <div class="owl-carousel testimonial_slider floatCss" id="testimonial_slider">
                                @foreach ($testimonials as $testimonial)
                                    <div class="item">
                                        <div class="single-testimonial floatCss">
                                            <p>{{ $testimonial->description }}</p>
                                            <div class="ts-mn-block floatCss">
                                                <div class="ts-mn-block-inner floatCss">
                                                    <div class="mn-user-photo"><img src="{{ asset('storage/' . $testimonial->icon) }}" alt="icon" />
                                                    <!-- "images/user-photo.svg" -->
                                                    </div>
                                                    <div class="mn-user-info-wr">
                                                        <div class="mn-user-info-sd floatCss">
                                                            <h3>{{ $testimonial->name }}</h3>
                                                            <p>{{ $testimonial->university }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- <div class="item">
                                    <div class="single-testimonial floatCss">
                                        <p>HES made my transition to university so much easier! From choosing
                                            the right program to understanding the application details, they
                                            were there every step of the way. Now, I'm studying engineering at
                                            one of Australia’s top universities, and I couldn’t be happier. AHES
                                            made it all possible!</p>
                                        <div class="ts-mn-block floatCss">
                                            <div class="ts-mn-block-inner floatCss">
                                                <div class="mn-user-photo"><img src="images/user-photo.svg" alt="" />
                                                </div>
                                                <div class="mn-user-info-wr">
                                                    <div class="mn-user-info-sd floatCss">
                                                        <h3>Rashid Haider</h3>
                                                        <p>University of Australia</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="single-testimonial floatCss">
                                        <p>HES made my transition to university so much easier! From choosing
                                            the right program to understanding the application details, they
                                            were there every step of the way. Now, I'm studying engineering at
                                            one of Australia’s top universities, and I couldn’t be happier. AHES
                                            made it all possible!</p>
                                        <div class="ts-mn-block floatCss">
                                            <div class="ts-mn-block-inner floatCss">
                                                <div class="mn-user-photo"><img src="images/user-photo.svg" alt="" />
                                                </div>
                                                <div class="mn-user-info-wr">
                                                    <div class="mn-user-info-sd floatCss">
                                                        <h3>Rashid Haider</h3>
                                                        <p>University of Australia</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>