<div id="page-content">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>Contact Us</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="<?php echo $baseUrl; ?>/home"
                            title="Back to the home page">Home</a><span class="main-title fw-bold"><i
                                class="icon anm anm-angle-right-l"></i>Contact Us</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container contact-style1">
        <!-- Contact Form - Details -->
        <div class="contact-form-details section pt-0">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                    <!-- Contact Form -->
                    <div class="formFeilds contact-form form-vertical mb-4 mb-md-0">
                        <div class="section-header">
                            <h2>Let's Get in touch!</h2>

                        </div>

                        <div name="contactus" method="post" id="contact-form" class="contact-form">
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Name" />
                                        <span class="error_msg" id="name_error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Email" />
                                        <span class="error_msg" id="email_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" type="tel" id="phone" name="phone"
                                            pattern="[0-9\-]*" placeholder="Phone Number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" id="subject" name="subject" class="form-control"
                                            placeholder="Subject" />
                                        <span class="error_msg" id="subject_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <textarea id="message" name="message" class="form-control" rows="5"
                                            placeholder="Message"></textarea>
                                        <span class="error_msg" id="message_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group mailsendbtn mb-0 w-100">
                                        <button class="btn btn-lg" onclick="save_details()">Send massage
                                        </button>
                                        <div class="loading"><img class="img-fluid"
                                                src="assets/images/icons/ajax-loader.gif" alt="loading" width="16"
                                                height="16"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="response-msg"></div>
                    </div>
                    <!-- End Contact Form -->
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <!-- Contact Details -->
                    <div class="contact-details bg-block">
                        <h3 class="mb-3 fs-5">Store information</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2 address">
                                <strong class="d-block mb-2">Address :</strong>
                                <p><i class="icon anm anm-map-marker-al me-2 d-none"></i> <?php echo $system_address; ?>
                                </p>
                            </li>
                            <li class="mb-2 phone"><strong>Phone :</strong><i
                                    class="icon anm anm-phone me-2 d-none"></i> <a
                                    href="<?php echo $system_ph_num; ?>"><?php echo $system_ph_num; ?></a></li>
                            <li class="mb-0 email"><strong>Email :</strong><i
                                    class="icon anm anm-envelope-l me-2 d-none"></i> <a
                                    href="mailto:<?php echo $system_email; ?>"><?php echo $system_email; ?></a></li>
                        </ul>
                        <hr>
                        <div class="follow-us">
                            <label class="d-block mb-3"><strong>Stay Connected</strong></label>
                            <ul class="list-inline social-icons">
                                <li class="list-inline-item"><a
                                        href="https://www.facebook.com/profile.php?id=61556251651113&mibextid=ZbWKwL"
                                        title="Facebook"><i class="icon anm anm-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a
                                        href="https://x.com/TheNoteBazaar?t=2V6NM-JOEzLCeQkFyc-deg&s=09"
                                        title="Twitter"><i class="icon anm anm-twitter"></i></a></li>
                                <li class="list-inline-item"><a
                                        href="https://www.linkedin.com/in/note-bazaar-0875222b3?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                                        title="Linkedin"><i class="icon anm anm-linkedin-in"></i></a></li>
                                <li class="list-inline-item"><a
                                        href="https://www.instagram.com/thenotebazaar?igsh=MzI5aGRva211bjBo"
                                        title="Instagram"><i class="icon anm anm-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Contact Details -->
                </div>
            </div>
        </div>
        <!-- End Contact Form - Details -->

        <!-- Contact Map -->
        <div class="contact-maps section p-0">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="map-section ratio ratio-16x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7003.019291140213!2d77.22654561181656!3d28.644455018007317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd7c440f2697%3A0x7ecee74ebf7a0520!2s2265Main%20bazar%20turkman%20gate%20Delhi%20110006!5e0!3m2!1sen!2sin!4v1707827797871!5m2!1sen!2sin"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="map-section-overlay-wrapper">
                            <div class="map-section-overlay rounded-0">
                                <h3>Our store</h3>
                                <div class="content mb-3">
                                    <p class="mb-2">1st floor, Mohalla Qabristan, Turkman Gate, Daryaganj New Delhi</p>
                                    <p>Mon - Fri, 10am - 9pm<br>Saturday, 11am - 9pm<br>Sunday, 11am - 5pm</p>
                                </div>
                                <p><a href="https://www.google.com/maps?daddr=80+Spadina+Ave,+Toronto"
                                        class="btn btn-secondary btn-sm">Get directions</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Map -->
    </div>
    <!--End Main Content-->
</div>