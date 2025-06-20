<link href="frontend_assets/assets/global/plugins/icheck/skins/all.css?v=<?php echo $version; ?>" rel="stylesheet"
    type="text/css" />
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    body {
        background-color: #D0AC81 !important;
    }

    #termsCheckbox {
        margin-bottom: 8px;
    }
@media only screen and (min-width: 700px) {
   .illustration {
        width: 100%;
        height: 200px !important;
        margin-bottom: 1.5rem;
        position: relative;
        text-align: center;
    }
    #ph_num_div {
  padding: 25px;
  background-color: #f7f7f7;
  height: 92.5vh;
  margin-top: 0px !important;
  border-radius: 0px !important;
  overflow: hidden !important;
}
#otp_div {
  padding: 25px;
  background-color: #f7f7f7;
  height: 92.5vh;
  margin-top: 0px !important;
  border-radius: 0px !important;
  overflow: hidden !important;
}
    
}
    .text-center {
        text-align: center;
    }

    .illustration {
        width: 100%;
        height: 256px;
        margin-bottom: 1.5rem;
        position: relative;
        text-align: center;
    }

    .illustration img {
        width: 90%;
        height: 90%;
        object-fit: contain;
    }

    #ph_num_div {
        padding: 25px;
        background-color: #f7f7f7;
        height: 92.5vh;
        margin-top: 50px;
        border-radius: 35px 35px 0px 0px;
        overflow: hidden !important;
    }

    #otp_div {
        padding: 25px;
        background-color: #f7f7f7;
        height: 92.5vh;
        margin-top: 50px;
        border-radius: 35px 35px 0px 0px;
        overflow: hidden !important;
    }

    #Register_div {
        padding: 25px;
        background-color: #f7f7f7;
        height: 92.5vh;
        margin-top: 50px;
        border-radius: 35px 35px 0px 0px;
        overflow: hidden !important;
    }

    #welcomeback_div {
        padding: 25px;
        background-color: #f7f7f7;
        height: 92.5vh;
        margin-top: 50px;
        border-radius: 35px 35px 0px 0px;
        overflow: hidden !important;
        justify-content: center;
        align-items: center;
    }

    .row {
        padding-left: 0px !important;
        padding-right: 0px !important;
        margin-left: 0px !important;
        margin-right: 0px !important;
    }

    .container-fluid {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    .container {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    h1 {
        font-size: 2.5rem;
        color: #000000;
        margin-bottom: 1rem;
    }

    .subtitle {
        font-size: 16px;
        color: #202020;
        margin-bottom: 2rem;
        margin-top: -9px !important;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .user_heading {
        color: #fff;
        text-align: center;
        margin-bottom: 2.5rem;
        padding-top: 30px;
        font-size: 25px;
    }

    #me-2:checked {
        background-color: #b5753e !important;
    }

    .role-card:hover {
        transform: translateY(-5px);
    }

    .role-card img {
        max-width: 76%;
        height: auto;
        margin-bottom: 1.5rem;
    }

    .role-card h2 {
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }

    .role-card p {
        color: #666;
        margin-bottom: 0;
    }

    #usertype_div {
        background-color: #deb887;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    label {
        display: block;
        text-transform: uppercase;
        color: #8f8f8f;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    input {
        width: 100%;
        padding: 0.75rem 1rem;
        /* border: 1px solid #d0ac81; */
        border-radius: 8px;
        font-size: 1rem;
        outline: none;
        transition: all 0.2sease;
        height: 50px;
    }

    input:focus {
        border-color: #b5753e;
        box-shadow: 0 0 0 2px rgba(181, 117, 62, 0.2);
    }

    input::placeholder {
        color: #a0a0a0;
    }

    .h1text {
        font-size: 25px;
        font-weight: 550;
    }

    #sendOTPButton {
        width: 100%;
        padding: 0.8rem;
        background-color: #b5753e;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.125rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    #sendOTPButton:hover {
        background-color: #d0ac81;
    }

    @media (max-width: 480px) {
        /* .container {
                padding: 1rem;
            } */

        h1 {
            font-size: 2rem;
        }

        .illustration {
            height: 200px;
        }
    }

    /* OTP */
    :root {
        --primary-color: #b5753e;
        --primary-hover: #a66b38;
    }


    .img-logo {
        width: 300px;
    }

    .bg-body {
        background-color: #a66b38 !important;
    }

    .illustration {
        max-width: 100%;
        height: auto;
        aspect-ratio: 1.5;
        object-fit: contain;
    }

    .otp-input {
        width: 48px !important;
        height: 48px !important;
        padding: 0 !important;
        text-align: center;
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        border: 2px solid #dee2e6 !important;
        border-radius: 0.5rem !important;
    }

    .otp-input:focus {
        border-color: var(--primary-color) !important;
        box-shadow: none !important;
    }

    .btn-primary {
        width: 100%;
        padding: 0.8rem;
        background-color: #b5753e;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.125rem;
        cursor: pointer;
        transition: background-color 0.2sease;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .back-btn:hover {
        color: var(--primary-color) !important;
    }

    /* Mobile Responsiveness */
    @media (max-width: 576px) {
        .otp-input {
            width: 40px !important;
            height: 40px !important;
        }
    }

    /* User Type */
    .modal-custom {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        width: 90%;
        max-width: 400px;
        position: relative;
    }

    .selection-button {
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #000;
        border-radius: 10px;
        background: white;
        text-align: center;
        transition: all 0.3s ease;
        font-size: 18px;
        font-weight: 550;
    }

    .modal-title {
        font-size: 20px;
        text-align: center;
    }

    .modal-header {
        justify-content: center;
    }

    .selection-button:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }

    .selection-button.active {
        border-color: #fff;
        background-color: #d0ac81;
        color: #fff;
    }

    .next-button {
        width: 100%;
        padding: 1rem;
        background-color: #a66829;
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 500;
        margin-top: 1rem;
        font-size: 20px;
    }

    .next-button:hover {
        background-color: #a66829;
    }

    .next-button:disabled {
        background-color: #a66829;
        cursor: not-allowed;
    }

    h2 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .buyer-text {
        text-align: left;
        font-size: 14px;
        font-weight: 400;
        margin: 8px 0px;
    }

    .selection-button {
        text-align: left !important;
    }

    .modal .modal-body {
        padding: 0px 15px 20px;
    }

    .modal .modal-header {
        border-bottom: 0px !important;
    }

    #what-kind {
        max-height: 80vh !important;
        overflow-y: auto;
    }

    #usertype_div {
        height: 100vh;
        overflow: hidden;
    }

    .page-wrapper {
        padding-bottom: 0px !important;
        overflow: hidden;
    }
    
    
</style>