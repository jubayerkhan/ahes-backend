

<div class="employee-section floatCss">
    <div class="container">
        <div class="row alignCenter-content">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="es-left-tittle floatCss">
                    <h2>The people behind AHES</h2>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="es-left-tittle floatCss">
                    <p>The team consists of registered migration agents with extensive experience and in-depth
                        knowledge of Australian immigration laws. Each client receives personalized advice and
                        solutions tailored to their unique circumstances.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($teamMembers as $member)
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="single-people-block floatCss">
                        <div class="emp-photo floatCss"><img src="{{ asset($member['photo']) }}" alt="" /></div>
                        <div class="emp-container floatCss">
                            <div class="emp-info floatCss">
                                <h3>{{ $member['name'] }}</h3>
                                <p>{{ $member['role'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- <div class="col-12 col-md-3 col-lg-3">
                <div class="single-people-block floatCss">
                    <div class="emp-photo floatCss"><img src="images/emp-photo-2.png" alt="" /></div>
                    <div class="emp-container floatCss">
                        <div class="emp-info floatCss">
                            <h3>Joel Hauer</h3>
                            <p>Co-founder</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <div class="single-people-block floatCss">
                    <div class="emp-photo floatCss"><img src="images/emp-photo-3.png" alt="" /></div>
                    <div class="emp-container floatCss">
                        <div class="emp-info floatCss">
                            <h3>Joel Hauer</h3>
                            <p>Co-founder</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <div class="single-people-block floatCss">
                    <div class="emp-photo floatCss"><img src="images/emp-photo-4.png" alt="" /></div>
                    <div class="emp-container floatCss">
                        <div class="emp-info floatCss">
                            <h3>Joel Hauer</h3>
                            <p>Co-founder</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>