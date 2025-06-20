<link rel="stylesheet" href="assets/css/vendor/photoswipe.min.css?v=<?php echo $version; ?>">
<link rel="stylesheet" href="assets/css/product-details.css?v=<?php echo $version; ?>">

<style>
    .product-form-border {
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        padding: 15px 0;
        margin: 10px 0 15px !important;
    }

    .confirm-option-div {
        text-align: left !important;
        margin-top: 1px !important;
        width: fit-content;
        background: #ffe9d3 !important;
        margin: auto;
        padding: 13px;
        border-radius: 7px;
        box-shadow: none !important;
    }

    .back-button {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 1000;
        color: #000;
        font-size: 20px;
    }

    .image-counter {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.8);
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 14px;
    }

    .carousel-item img {
        height: 300px;
        object-fit: cover;
    }

    .price {
        color: #C17533 !important;
        font-weight: bold;
    }

    .success-badge {
        color: #fff !important;
    }

    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 10px 0;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        max-width: 480px;
        margin: 0 auto;
    }

    .nav-item {
        text-align: center;
        font-size: 12px;
    }

    .nav-item i {
        font-size: 20px;
        color: #666;
    }

    .add-button {
        width: 50px;
        height: 50px;
        background: #C17533;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin: -25px auto 0;
    }

    .seller-info {
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin: 15px 0;
    }

    .view-seller-btn {
        background: #C17533;
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 8px;
    }

    .error-modal {
        max-width: 400px;
        margin: 100px auto;
        text-align: center;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background-color: white;
        position: relative;
    }

    .btn-warning {
        background-color: #b27c44 !important;
        border: none !important;
    }

    .error-icon {
        width: 80px;
        height: 80px;
        background-color: #e60000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 4px 8px rgba(230, 0, 0, 0.2);
    }

    .error-icon .x-mark {
        color: white;
        font-size: 40px;
        font-weight: bold;
    }

    .error-message {
        font-size: 20px;
        color: #333;
        margin-bottom: 25px;
    }

    .add-credits-btn {
        background-color: #b27c44;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-credits-btn:hover {
        background-color: #9e6d3a;
    }

    .info-badge {
        color: #fff !important;
        background-color: #c17533 !important;
    }

    .buyer-request-div {
        padding: 20px;
    }

    .badges {
        padding: 1px 9px;
        border-radius: 14px;
        font-size: 10px;
        font-weight: 600;
        position: absolute;
        right: 15px;
        padding-top: 2px;
        line-height: initial;
    }

    /* .buyer-request-div .user-info-div {
        color: #fff !important;
    }

    .user-info-div {
        color: #fff !important;
    } */

    .buyer-request-div {
        width: 100%;
        background-color: #ffe9d3 !important;
        padding: 15px;
        box-sizing: border-box;
        border-radius: 15px;
        position: relative;
        margin-bottom: 6px;
    }

    .uicon-u {
        font-size: 22px;
    }

    .edit-right {
        right: 20px;
        position: absolute;
        font-size: 20px;
    }

    .f-20 {
        font-size: 25px;
    }

    .f-15 {
        font-size: 15px;
    }

    .uicon {
        font-size: 18px;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: #000 !important;
    }


    hr,
    pre {
        margin: 10px 0;
    }

    /* Modal animation */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.show {
        opacity: 1;
    }

    /* Close button */
    .btn-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        color: black;
        /* Make sure the color is visible */
        opacity: 1;
        /* Ensure full visibility */
    }

    /* Add a hover effect */
    .btn-close:hover {
        color: red;
        /* Optional: Change color on hover */
        background-color: #f0f0f0;
    }

    .offer-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 350px;
        padding: 12px;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .offer-text {
        display: flex;
        flex-direction: column;
    }

    .offer-title {
        font-size: 14px;
        font-weight: bold;
        color: #8B5A2B;
        margin: 0;
    }

    .offer-subtext {
        font-size: 12px;
        color: #555;
        margin: 5px 0 0 0;
    }

    .arrow {
        font-size: 20px;
        color: #555;
        cursor: pointer;
    }

    .offer-button {
        padding: 8px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        position: absolute;
        right: 10px;
        bottom: 10px;
    }

    .offer-button:hover {
        background-color: #0056b3;
    }

    /* General Modal Styling */
    .modal-dialog {
        max-width: 90%;
        /* Adjust width for better mobile responsiveness */
        margin: 10px auto;
        /* Center the modal */
    }

    .modal-content {
        max-height: 85vh;
        /* Prevent modal from exceeding screen height */
        overflow: hidden;
        /* Hide overflow content */
        border-radius: 10px;
        /* Rounded corners */
    }

    /* Scrollable Modal Body */
    .modal-body {
        max-height: 70vh;
        /* Enables scrolling inside the modal */
        overflow-y: auto;
        /* Enables vertical scrolling */
        padding: 15px;
    }

    /* Modal Header */
    .modal-header {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 15px;
    }

    .modal-title {
        font-size: 1rem;
        /* Smaller font for mobile */
        font-weight: 600;
        color: #333;
    }

    .btn-close {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        color: #333;
    }

    /* Offer Card Styles */
    .offer-card {
        border-bottom: 1px solid #f0f0f0;
        padding: 15px;
        background-color: #fff;
        border-radius: 5px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Buyer Info */
    .avatar {
        width: 35px;
        height: 35px;
        background-color: #FFE5D6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FF6B00;
        font-weight: 500;
        font-size: 0.9rem;
        /* Smaller avatar text */
    }

    .user-name {
        font-weight: 500;
        font-size: 0.9rem;
        color: #333;
    }

    .phone-number {
        color: #666;
        font-size: 0.8rem;
        margin-bottom: 4px;
    }

    .offered-price {
        color: #22C55E;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .message {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }

    /* Buttons */
    .btn-accept,
    .btn-negotiate {
        font-size: 0.8rem;
        /* Smaller buttons for mobile */
        padding: 6px 15px;
        border-radius: 5px;
        width: 100%;
        /* Full width buttons */
        text-align: center;
    }

    .btn-accept {
        background-color: #C17F59;
        color: white;
        border: none;
    }

    .btn-accept:hover {
        background-color: #A66B47;
    }

    .btn-negotiate {
        border: 1px solid #C17F59;
        color: #C17F59;
        background: transparent;
    }

    .btn-negotiate:hover {
        background-color: #FFF8F5;
    }




    /* Responsive Adjustments */
    @media (max-width: 576px) {

        /* Ensure modal takes full width and is centered */
        .modal-dialog {
            max-width: 95%;
            margin: 10px auto;
        }

        /* Make the modal fit within the screen height */
        .modal-content {
            max-height: 90vh;
            border-radius: 12px;
            /* Smooth edges */
            overflow: hidden;
            /* Prevent any unnecessary scrolling */
        }

        /* Ensure body has enough scrollable space */
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
            /* Enable vertical scrolling */
            padding: 15px;
        }

        /* Reduce title size for better mobile view */
        .modal-title {
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
        }

        /* Center close button and ensure correct spacing */
        .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 16px;
        }

        /* Styling for Offer Cards */
        .offer-card {
            padding: 10px;
            border-radius: 10px;
            background: #f8f8f8;
            margin-bottom: 10px;
        }

        /* Avatar adjustments */
        .avatar {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #a86b3d;
            color: white;
            font-weight: bold;
            border-radius: 50%;
        }

        /* Improve button sizes and stack them */
        .btn-accept,
        .btn-negotiate {
            font-size: 0.85rem;
            padding: 8px 14px;
            width: 100%;
            /* Stack buttons */
            border-radius: 8px;
            font-weight: bold;
        }

        /* Primary button style */
        .btn-primary {
            width: 100%;
            background: #a86b3d;
            color: white;
            font-size: 16px;
            padding: 12px;
            text-align: center;
            border-radius: 8px;
            border: none;
        }

        /* Button hover effect */
        .btn-primary:hover {
            background: #8c572b;
        }
    }


    /* Confirmation Box */
    .confirm-box {
        margin-top: 15px;
        padding: 20px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        max-width: 400px;
    }

    .confirm-box p {
        margin-bottom: 15px;
        font-size: 14px;
        color: #333;
    }

    /* Buttons inside the confirmation box */
    .confirm-box-actions {
        display: flex;
        justify-content: space-between;
    }

    .confirm-box-actions .btn {
        width: 48%;
    }

    /* Styling for main button */
    .product-form-cart-submit {
        font-size: 16px;
        font-weight: bold;
    }

    /* Confirmation Box */
    .confirm-box {
        margin-top: 15px;
        padding: 20px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        max-width: 400px;
    }

    .confirm-box p {
        margin-bottom: 15px;
        font-size: 14px;
        color: #333;
    }

    /* Buttons inside the confirmation box */
    .confirm-box-actions {
        display: flex;
        justify-content: space-between;
    }

    .confirm-box-actions .btn {
        width: 48%;
    }

    /* Styling for main button */
    .product-form-cart-submit {
        font-size: 16px;
        font-weight: bold;
    }


    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: #fff;
        margin: 0 0 4px;
        font-family: Heebo, sans-serif;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: 0;
        overflow-wrap: break-word;
    }

    #product_name {
        color: #c17533 !important;
        text-transform: capitalize;
    }

    #seller_info {
        color: #fd7e14;
        text-transform: capitalize;
    }

    #seller_name {
        text-transform: capitalize;

    }

    #seller_num {
        text-transform: capitalize;

    }
</style>