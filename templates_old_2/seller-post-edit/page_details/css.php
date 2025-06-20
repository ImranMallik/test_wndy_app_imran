<style>
    :root {
        --primary-color: #b5753e;
        --secondary-color: #969696;
        --border-color: #e4e4e4;
    }

    .btn-sm {
        padding: 2px 6px !important;
        background-color: #b5753e !important;
    }

    /* Custom Tooltip Styles */
    .tooltip-inner {
        background-color: #b5753e !important;
        /* Custom background color */
        color: #FFF !important;
        /* White text color */
        font-size: 0.9rem;
        /* Smaller text size */
        max-width: 100% !important;
        /* Ensure tooltip width is 100% */
        white-space: normal;
        /* Allow text to wrap */
        margin: 0px 10px 0px 10px;
        border-radius: 5px !important;
        text-transform: lowercase !important;
    }

    .tooltip-inner::first-letter {
        text-transform: uppercase;
    }

    .tooltip-arrow {
        border-top-color: #b5753e !important;
        /* Match tooltip arrow color */
    }

    .seller-post-continue {
        position: fixed;
        bottom: 0px !important;
        width: 90% !important;
        right: 50px;
        left: 17px;
        z-index: 99;
    }

    category-body {
        background-color: white;
        min-height: 100vh;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        align-items: center;
    }

    .step {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--border-color);
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .step.active {
        background-color: var(--primary-color);
        color: white;
    }

    .step-line {
        width: 48px;
        height: 2px;
        background-color: var(--border-color);
    }

    @media only screen and (max-width: 480px) {
        .header {
            min-height: 50px;
        }
    }

    /* Categories */
    .categories-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        height: auto;
        overflow: auto;
        padding-bottom: 10px;
    }

    .category-item {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background-color: white;
        text-align: left;
        transition: all 0.3s ease;
    }

    .category-item:hover {
        border-color: var(--primary-color);
    }

    .category-item.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .category-item i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    .category-item.active i {
        color: white;
    }

    .radio-circle {
        width: 16px;
        height: 16px;
        border: 2px solid var(--border-color);
        border-radius: 50%;
    }

    .category-item.active .radio-circle {
        border-color: white;
        background-color: white;
    }

    .category-item.active img {
        background: #fff;
        padding: 2px;
        border-radius: 5px;
    }

    /* Bootstrap Overrides */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 12px;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background-color: #96602f;
        border-color: #96602f;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .text-secondary {
        color: var(--secondary-color) !important;
    }

    /* Seller Post Category Start */

    .rounded-15 {
        border-radius: 15px !important;
    }

    /* Custom styles to match the design */
    .seeler-item-details-bg {
        background-color: white;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .header {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1000;
        border-bottom: 1px solid #f0f0f0;
    }

    /* Progress Steps */
    .progress-steps .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f1f1;
        color: #8f8f8f;
        font-weight: 500;
    }

    .progress-steps .step-line {
        width: 16px;
        height: 2px;
        background: #dbdbdb;
    }

    .progress-steps .step-circle.completed {
        background: #b5753e;
        color: white;
    }

    .progress-steps .step-circle.active {
        background: white;
        border: 2px solid #b5753e;
        color: #b5753e;
    }

    .progress-steps .step-line.completed {
        background: #b5753e;
    }

    /* Form Styles */
    .form-control {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e2e2;
        border-radius: 0.5rem;
    }

    .form-control::placeholder {
        color: #a0a0a0;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    /* Image Upload */
    .image-upload-container {
        overflow-x: auto;
        padding: 0.25rem;
    }

    .image-preview {
        width: 96px;
        height: 96px;
        flex-shrink: 0;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.5rem;
    }

    .upload-btn {
        width: 96px;
        height: 96px;
        border-style: dashed !important;
        border-width: 2px !important;
        flex-shrink: 0;
        color: #8f8f8f !important;
    }

    /* Continue Button */
    .btn-primary {
        background-color: #b5753e !important;
        border-color: #b5753e !important;
    }

    .btn-primary:hover {
        background-color: #a66935 !important;
        border-color: #a66935 !important;

    }

    .addAddress:hover {
        color: #fff !important;
        background-color: rgb(175, 134, 99) !important;
    }

    /* Seller Post Category End */


    /* Address manager start */
    .progress-step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #b5753e;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .progress-line {
        flex-grow: 1;
        height: 2px;
        background-color: #b5753e;
        margin: 0 10px;
    }

    .step-text {
        color: #b5753e;
        font-size: 14px;
        text-align: center;
        margin-top: 8px;
    }

    .address-item {
        border-bottom: 1px solid #eee;
        padding: 20px 0;
        position: relative;
        cursor: pointer;
    }

    .address-type {
        color: #666;
        font-size: 14px;
    }

    .address-text {
        color: #333;
        margin-bottom: 0;
        padding-right: 25px;
    }

    .add-address-btn {
        background-color: white;
        color: #b5753e;
        border: 2px solid #b5753e;
        border-radius: 25px;
        padding: 12px;
        width: 100%;
        margin-top: 20px;
    }

    .default-label {
        color: #b5753e;
        font-weight: 500;
    }

    .notice-box {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        color: #666;
        text-align: center;
        margin: 20px 0;
    }

    .back-button {
        color: #000;
        text-decoration: none;
        font-size: 24px;
        margin-right: 15px;
    }

    .chevron-icon {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        color: #ccc;
        font-size: 20px;
    }

    /* Make address items look interactive */
    .address-item:hover {
        background-color: #f8f9fa;
    }

    .input-error {
        border: 0.1px solid #dc3545 !important;
        border-radius: 5px;
    }

    .radio-error .form-check-input {
        outline: 0.1px solid #dc3545 !important;
        border-radius: 50%;
    }

    .image-upload-container.input-error {
        border: 0.1px solid #dc3545 !important;
        padding: 5px;
        border-radius: 10px;
    }

    .address-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .address-card {
        background: white;
        border: none;
        margin-bottom: 20px;
    }

    .address-type {
        font-size: 16px;
        font-weight: 600;
        color: #000;
        margin-bottom: 8px;
    }

    .address-text {
        color: #666;
        font-size: 14px;
        line-height: 1.4;
    }

    /* .add-address-btn {
            background-color: #B47941;
            border: none;
            color: white;
            padding: 15px;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            max-width: 560px;
            border-radius: 8px;
        } */

    .add-address-btn:hover {
        background-color: #96632F;
    }

    .edit-icon {
        color: #666;
        font-size: 1.2rem;
    }

    .status-icons {
        gap: 15px;
    }

    .form-check-input {
        width: 16px !important;
        height: 16px !important;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        margin: 0px !important;
        padding: 0px !important;
        padding-left: 0em !important;
    }

    .address-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
    }

    /* Default address highlight */
    .address-card.default-selected {
        border: 2px solid #b5753e;
        background: #f8f1eb;
    }

    /* Selected address highlight with border radius */
    .address-card.selected {
        border: 2px solid #b5753e !important;
        background: #fef6f0;
        border-radius: 10px;
    }

    /* Regular address card */
    .address-card {
        background: #ffffff;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        padding: 15px;
        transition: all 0.3s ease-in-out;
    }

    .address-card:hover {
        background: #f8f9fa;
    }

    /* Hide default text when switching address */
    .default-text {
        font-weight: bold;
        color: #b5753e;
        display: none;
    }

    .edit-icon {
        color: #007bff;
    }
    
    
    .progress-steps-address {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            margin-top: 20px;
        }
.step-address {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .step-icon-address {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 8px;
        }

        .step-text-address {
            font-size: 12px;
            color: #666;
        }

        .step-line-address {
            height: 2px;
            background-color: var(--primary-color);
            width: 60px;
            margin: 0 -10px;
            margin-top: 16px;
        }

</style>