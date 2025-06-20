<style>
    :root {
        --primary-color: #b5753e;
        --secondary-color: #969696;
        --border-color: #e4e4e4;
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

    /* Categories */
    .categories-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .category-item {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
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

    /* Address manager end */
</style>