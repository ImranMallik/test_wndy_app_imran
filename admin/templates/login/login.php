<!--======================Background overlay===========---->
<div class="background_overlay">
	<div class="preloader spinner spinner-primary"></div>
</div>
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
	<!--begin::Login-->

	<div class="login login-3 login-signin-on d-flex flex-row-fluid" id="kt_login">

		<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(../backend_assets/media/bg/bg-1.jpg);">
			<div class="login-form text-center text-white p-7 position-relative overflow-hidden" style="background: #e9e9e921; border-radius: 30px;">
				<!--begin::Login Header-->
				<div class="d-flex flex-center mb-15">
					<a href="#">
						<img style="width: 100%;" src="../upload_content/upload_img/system_img/<?php echo $system_logo; ?>" class="max-h-100px" alt="" />
					</a>
				</div>
				<!--end::Login Header-->
				<!--begin::Login Sign in form-->
				<div class="login-signin">
					<div class="mb-20">
						<h3>Sign In To Admin</h3>
						<p class="opacity-60 font-weight-bold">Enter your details to login to your account:</p>
					</div>
					<div class="form" id="kt_login_signin_form">
						<div class="form-group">
							<input class="form-control h-auto text-white placeholder-white opacity-70 rounded-pill border-0 py-4 px-8 mb-5" type="text" placeholder="User Id" id="user_id" name="user_id" autocomplete="off" required maxlength="50" style="background: #00000047;" />
						</div>
						<div class="form-group">
							<input class="form-control h-auto text-white placeholder-white opacity-70 rounded-pill border-0 py-4 px-8 mb-5" type="password" placeholder="Password" id="password" name="password" required maxlength="50" style="background: #00000047;" />
						</div>
						<div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8">
							<div class="checkbox-inline">
								<label class="checkbox checkbox-outline checkbox-white text-white m-0">
									<input type="checkbox" name="remember" id="remember" />
									<span></span>Remember Me</label>
							</div>
						</div>
						<div class="form-group text-center mt-10">
							<button onclick="sign_in()" id="kt_login_signin_submit" class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3">Sign In</button>
						</div>
					</div>
				</div>
				<!--end::Login Sign in form-->
			</div>
		</div>

	</div>

	<!--end::Login-->
</div>
<!--end::Main-->