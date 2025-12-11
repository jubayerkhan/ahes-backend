<div class="why-choose-us-section floatCss" style="background-image:url(images/choose-us-bg.png)">
    <div class="container">
        <div class="row d-flex justify-content-end">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="section-tittle floatCss">
                    <h2>Why Choose Us</h2>
                </div>
                <div class="why-chhose-us-content floatCss">
                    @foreach ($whypoints as $w)
                        <div class="single-wcuc floatCss">
                            <div class="single-wcuc-inner floatCss">
                                <div class="cnt-icon-block"><span><img src="{{ asset("storage/". $w->icon) }}" alt="" /></span>
                                </div>
                                <div class="cnt-info-block">
                                    <div class="wcuc-inner-block floatCss">
                                        <h3>{{ $w->title }}</h3>
                                        <p>{{ $w->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- <div class="single-wcuc floatCss">
                        <div class="single-wcuc-inner floatCss">
                            <div class="cnt-icon-block"><span><img src="images/choose-us-icon-2.svg" alt="" /></span>
                            </div>
                            <div class="cnt-info-block">
                                <div class="wcuc-inner-block floatCss">
                                    <h3>Reliable Expertise and Knowledge</h3>
                                    <p>Our certified consultants bring years of experience in the Australian
                                        higher education field, providing you with accurate, up-to-date
                                        information and personalized advice you can trust.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-wcuc floatCss">
                        <div class="single-wcuc-inner floatCss">
                            <div class="cnt-icon-block"><span><img src="images/choose-us-icon-3.svg" alt="" /></span>
                            </div>
                            <div class="cnt-info-block">
                                <div class="wcuc-inner-block floatCss">
                                    <h3>Hassle-Free Application Process</h3>
                                    <p>Our team manages every step of your application process, from
                                        documentation to submission, ensuring a seamless experience that
                                        maximizes your chances of success.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-wcuc floatCss">
                        <div class="single-wcuc-inner floatCss">
                            <div class="cnt-icon-block"><span><img src="images/choose-us-icon-4.svg" alt="" /></span>
                            </div>
                            <div class="cnt-info-block">
                                <div class="wcuc-inner-block floatCss">
                                    <h3>Comprehensive, Personalized Guidance</h3>
                                    <p>We’re here to guide you at every step, offering tailored support that
                                        fits your unique needs and helps you confidently navigate your path in
                                        higher education.</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>