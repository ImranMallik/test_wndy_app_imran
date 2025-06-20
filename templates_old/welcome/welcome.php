<div class="slider-container">
    <div class="slider">
        <div class="slide" style="padding:0rem !important; margin-top:0px !important;">
            <!-- <h1 class="slide-title">Welcome to the wndy app</h1> -->
            <div class="slide-content bg-img-1st">
                <div class="pattern"></div>
            </div>
        </div>
        <div class="slide">
            <!-- <h1 class="slide-title">Welcome to the wndy app</h1> -->
            <div class="slide-content">
                <div class="logo"><img src="frontend_assets/img-icon/slider_logo.png?v=<?php echo $version; ?>" alt="">
                </div>
            </div>
        </div>
        <!--<div class="slide">-->
            
        <!--    <div class="slide-content">-->
        <!--        <div class="logo"><img src="frontend_assets/img-icon/slider_logo.png?v=<?php echo $version; ?>" alt="">-->
        <!--        </div>-->
        <!--        <div class="tagline">WASTE NOT DEAD YET</div>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- <div class="slide">
                    <h1 class="slide-title">Welcome to the wndy app</h1>
                    <div class="slide-content">
                        <div class="logo"><img src="frontend_assets/img-icon/slider_logo.png?v=<?php echo $version; ?>" alt=""></div>
                        <div class="tagline">WASTE NOT DEAD YET</div>
                    </div>
                </div> -->
        <div class="slide">
            <!-- <h1 class="slide-title">Welcome to the wndy app</h1> -->
            <div class="slide-content">
                <div class="logo"><img src="frontend_assets/img-icon/slider_logo.png?v=<?php echo $version; ?>" alt="">
                </div>
                <div class="tagline">WASTE NOT DEAD YET</div>

            </div>
            <button class="get-started-btn" onclick="sliderEnd()">Let's Get Started</button>
        </div>
    </div>
    <div class="dots d-none"></div>
    <button class="nav-button prev d-none">←</button>
    <button class="nav-button next d-none">→</button>
</div>
<!-- Welcome screen End -->
<!-- Language screen Start -->
<div class="language-body">
    <div class="container-language">
        <span class="language-heading">What language do you prefer?</span>
        <form id="languageForm">
            <div class="language-options" style="height:410px; overflow:auto;">


            </div>
            <button type="submit" class="next-button" onclick="showLogin()">NEXT</button>
        </form>
    </div>
</div>