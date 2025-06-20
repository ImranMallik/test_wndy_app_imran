<script src="frontend_assets/assets/global/plugins/icheck/icheck.min.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script>
 const phoneInput = document.getElementById("ph_num");

    phoneInput.addEventListener("input", function () {
      // Remove anything that isn't a digit
      this.value = this.value.replace(/\D/g, '');

      // Limit length to 10 digits
      if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
      }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const referralFromPHP = "<?php echo isset($referral_code) ? $referral_code : ''; ?>";
    if (referralFromPHP) {
        const referralInput = document.getElementById("referral_code");
        if (referralInput) {
            referralInput.value = referralFromPHP;
            referralInput.readOnly = true;
           
        }
    }
});
</script>

<script>
    var handleiCheck = function() {
        if (!$().iCheck) {
            return;
        }

        $('.icheck').each(function() {
            var checkboxClass = $(this).attr('data-checkbox') ? $(this).attr('data-checkbox') : 'icheckbox_minimal-grey';
            var radioClass = $(this).attr('data-radio') ? $(this).attr('data-radio') : 'iradio_minimal-grey';

            if (checkboxClass.indexOf('_line') > -1 || radioClass.indexOf('_line') > -1) {
                $(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass,
                    insert: '<div class="icheck_line-icon"></div>' + $(this).attr("data-label")
                });
            } else {
                $(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass
                });
            }
        });
    };
    handleiCheck();
    
    
    // function updateHiddenOtp() {
    //     let otpValue = "";
        
    //     // Loop through all OTP fields and concatenate values
    //     for (let i = 0; i < 6; i++) {
    //         let digit = document.getElementById(`otp-${i}`).value.trim();
    //         otpValue += digit;
    //     }

    //     // ✅ Set the concatenated OTP in the hidden field
    //     document.getElementById("otp").value = otpValue;

    //     // ✅ Debugging: Print OTP to console
    //     console.log("Updated Hidden OTP:", otpValue);
    // }
    // ✅ Function to update hidden OTP field
function updateHiddenOtp() {
    let otpValue = "";
    
    // Loop through all OTP fields and concatenate values
    for (let i = 0; i < 6; i++) {
        let digit = document.getElementById(`otp-${i}`).value.trim();
        otpValue += digit;
    }

    // ✅ Set the concatenated OTP in the hidden field
    document.getElementById("otp").value = otpValue;

    // ✅ Debugging: Print OTP to console
    // console.log("Updated Hidden OTP:", otpValue);
}

// ✅ Auto-Focus to Next OTP Field on Input & Handle Backspace
document.addEventListener("DOMContentLoaded", function () {
    let otpInputs = document.querySelectorAll(".otp-input");

    otpInputs.forEach((input, index) => {
        input.addEventListener("input", function () {
            updateHiddenOtp(); // Update hidden OTP field
            if (this.value.length === 1 && index < 5) {
                otpInputs[index + 1].focus(); // Move focus to next input
            }
        });

        input.addEventListener("keydown", function (event) {
            if (event.key === "Backspace" && this.value === "" && index > 0) {
                otpInputs[index - 1].focus(); 
            }
        });

        // ✅ Prevent typing more than one digit
        input.addEventListener("keypress", function (event) {
            if (!/^[0-9]$/.test(event.key)) {
                event.preventDefault();
            }
        });
    });
});

</script>
<script src="templates/user-login/controller.js?v=<?php echo $version; ?>"></script>