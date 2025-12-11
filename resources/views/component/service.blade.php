<div class="service-section floatCss">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tittle-center floatCss">
                    <h2>Our Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="service-slider-wrapper floatCss">
                    <div class="owl-carousel service-slider floatCss" id="service_slider">
                        @foreach ($services as $service)
                            <div class="item">
                                <div class="service-single">
                                    <a href="#">
                                        <div class="service-single-content floatCss">
                                            <div class="service-icon floatCss"><span><img src={{ asset('storage/' . $service->icon) }}
                                                        alt="logo" /></span></div>
                                            <h3> {{ $service->title }} </h3>
                                            <p> {{ $service->description }}</p>
                                            <div class="read-more-btn floatCss"><span>Learn More</span></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <!-- <div class="item">
                            <div class="service-single">
                                <a href="#">
                                    <div class="service-single-content floatCss">
                                        <div class="service-icon floatCss"><span><img src="images/info-gt.svg"
                                                    alt="Logo" /></span></div>
                                        <h3>Proper Information & Experienced Service</h3>
                                        <p>Our certified consultants are committed to providing accurate and
                                            up-to-date information. With years of experience, we deliver a
                                            service that combines expertise with a deep understanding of the
                                            Australian higher education system, making it easier for you to make
                                            informed decisions.</p>
                                        <div class="read-more-btn floatCss"><span>Learn More</span></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="service-single">
                                <a href="#">
                                    <div class="service-single-content floatCss">
                                        <div class="service-icon floatCss"><span><img src="images/processing.svg" alt="Logo" /></span></div>
                                        <h3>Application Processing</h3>
                                        <p>We streamline the application process from start to finish, ensuring
                                            every document and detail is handled with precision. Our team
                                            manages each step of the application journey, reducing stress and
                                            increasing your chances of a successful outcome.</p>
                                        <div class="read-more-btn floatCss"><span>Learn More</span></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="service-single">
                                <a href="#">
                                    <div class="service-single-content floatCss">
                                        <div class="service-icon floatCss"><span><img src="images/expert.svg"
                                                    alt="" /></span></div>
                                        <h3>Expert Guidance</h3>
                                        <p>Our consultants are here to support you at every stage, from
                                            selecting the right program to finalizing your enrolment. With
                                            personalized advice, we aim to make your path to higher education in
                                            Australia as smooth and rewarding as possible.</p>
                                        <div class="read-more-btn floatCss"><span>Learn More</span></div>
                                    </div>
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>