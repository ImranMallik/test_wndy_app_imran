<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
        font-family: Arial, sans-serif;
    }
.radio-input {
    appearance: none !important;
    
}
.bg-block.sm, .form-control, input, textarea {
    padding: 10px 10px !important;
}
    .language-body {
        height: 100vh !important;
    }

    .page-wrapper {
        padding-bottom: 0px !important;
    }

    .slider-container {
        position: relative;
        height: 100vh;
        overflow: hidden;
        background-color: #D2B48C;
    }

    .slider {
        display: flex;
        height: 100%;
        transition: transform 0.5s ease-in-out;
        margin: 0px !important;
    }

    .logo img {
        max-width: 200px;
    }


    .slide {
        min-width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem;
    }

    .bg-img-1st {
        background-image: url('frontend_assets/img-icon/Welcometothewndyapp.png');
        background-size: cover;
        /* Ensures the image covers the entire div */
        background-position: center;
        /* Centers the image */
        background-repeat: no-repeat;
        /* Prevents the image from repeating */
        width: 100vw;
        /* Full width */
        height: 100vh;
        /* Full height */
        flex: 1 !important;
    }

    .slide-title {
        color: #000;
        font-size: 1.25rem;
        margin: 2rem 0;
    }

    .slide-content {
        flex: 0.9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
    }

    .logo {
        font-size: 2.5rem;
        font-weight: bold;
        letter-spacing: 2px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 0.8s ease-out forwards;
    }

    .tagline {
        /* font-size: 0.875rem; */
        letter-spacing: 1px;
        color: #000;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 0.8s ease-out 0.2s forwards;
        font-weight: 600;
        font-size: 21px;
        Line-height: 34.96px;
    }

    .get-started-btn {
        margin-top: 2rem;
        padding: 1rem 4rem;
        background-color: white;
        color: black;
        border: none;
        border-radius: 5px;
        font-weight: 500;
        cursor: pointer;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 0.8s ease-out 0.4s forwards;
    }

    .get-started-btn:hover {
        background-color: #f8f8f8;
    }

    .dots {
        position: absolute;
        bottom: 2rem;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .dot.active {
        background-color: #000;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
    }

    .nav-button:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .prev {
        left: 1rem;
    }

    .next {
        right: 1rem;
    }

    .slide.active .logo,
    .slide.active .tagline,
    .slide.active .get-started-btn {
        animation-play-state: running;
    }

    .page-wrapper a {
        display: none;

    }

    .slider-container {
        display: block;
        /* Initially show the slider */
    }

    .page-wrapper {
        /* display: none; */

    }

    .language-body {
        min-height: 90vh !important;
        display: none;
        align-items: center;
        justify-content: center;
        background-color: #D4B595;
        padding: 50px 0px 0px 0px;
    }

    .container-language {
        width: 100%;
        max-width: 400px;
        background: white;
        border-radius: 32px 32px 0px 0px;
        padding: 1.5rem;
        text-align: center;
    }

    .language-options {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        margin-top: 20px;
    }


    .language-option {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .language-option:hover {
        background-color: #f8f8f8;
    }

    .radio-input {
        /* appearance: none; */
        width: 20px !important;
        height: 20px !important;
        border: 2px solid #999;
        border-radius: 50%;
        margin-right: 12px;
        position: relative;
        cursor: pointer;
    }

    .language-option:hover {
        background-color: #f8f8f8;
    }

    .radio-input {
        /* appearance: none; */
        width: 20px !important;
        height: 20px !important;
        border: 2px solid #999;
        border-radius: 50%;
        margin-right: 12px;
        position: relative;
        cursor: pointer;
    }

    .radio-input:checked {
        border-color: #B17B4F;
    }

    .radio-input:checked::after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #B17B4F;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .language-label {
        font-size: 1.125rem;
    }

    .next-button {
        width: 100%;
        padding: 1.25rem;
        background-color: #B17B4F;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-size: 1.125rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .next-button:hover {
        background-color: #9A6B44;
    }

    .language-heading {
        font-weight: 400;
        font-size: 20px;
        line-height: 27.28px;
        text-align: center;
    }
</style>