<!--begin::Page Vendors Styles(used by this page)-->
<style>
    /* .slider-img{
        height:90vh !important;
    } */

    .slideshow .wrap-caption {
        padding: 15px;
        background: #101010a3;
        border-radius: 5px;
    }

    /* .slider-img {
        height: 800px;
    }

    @media(max-width: 450px) {
        .slider-img {
            height: 250px;
        }

    } */

    .testimonial-text-section {
        height: 100px;
        overflow: hidden;
    }

    .set-color-change {
        color: red;
    }

    .index-demo1 .collection-slider .category-title {
        font-size: 16px !important;
    }

    .product-name-text {
        margin-bottom: 20px !important;
        background-color: #eaecf14d !important;
    }



    .index-demo1 .collection-slider .category-item .details {
        padding: 15px 15px;
        margin: 0 !important;
    }

    .zoom-scal img {
        border-radius: 50% !important;
    }

    .bg-dark {
        background-color: #000 !important;
    }

    .bg-gray {
        background-color: antiquewhite !important;
    }

    .index-demo1 .collection-slider .category-title {
        font-size: 18px;
        width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .arwOut5 .slick-arrow:hover,
    .slick-arrow-dots .slick-arrow:hover {
        background-color: rgb(210 209 209 / 90%);
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3) !important;
    }

    .arwOut5 .slick-arrow .slick-arrow-dots .slick-arrow {
        background-color: rgb(210 209 209 / 90%);
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3) !important;
    }

    .zoom-scal img {
        border-radius: 0% !important;
    }

    .arwOut5 .slick-arrow {
        background-color: lightgray;
    }

    @media only screen and (max-width: 600px) {
        .index-demo1 .collection-slider .category-title {
            font-size: 18px;
            width: auto;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

    }

    body {
        position: relative;
        min-height: 100%;
        top: 0px;
        overflow: hidden;
        padding-right: 0px !important;

    }

    /* General styles for the card */
    .product-box {
        border-radius: 15px;
        background-color: #f9f9f9;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .product-box:hover {
        transform: scale(1.05);
    }

    /* Styling for smaller screens */
    @media only screen and (max-width: 768px) {

        .product-image img {
            height: 120px;
            /* Smaller height for images */
        }

        .product-details .product-name {
            font-size: 12px;
            /* Smaller font size */
        }

        .product-details .product-category {
            font-size: 10px;
            /* Smaller font size */
        }

        .product-checkbox {
            transform: scale(1.1);
            /* Adjust checkbox size */
        }
    }

    /* Specific styles for iPhone screens */
    @media only screen and (max-width: 576px) {
        .product-box {
            margin-bottom: 10px;
        }

        .product-image img {
            height: 100px;
        }

        #nextButtonDiv {
            padding: 8px;
        }

        #nextButton {
            padding: 8px 20px;
        }
    }


    .filter-result-text-content {
        width: 100%;
        text-wrap: nowrap;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        background: #ff9797;
        border-radius: 11px;
        padding: 3px 8px;
    }

    /* .col-item {
        background-color: #f6f6f6;
        width: 100%;
        padding-top: 0px !important;
        margin-bottom: 4px;
    } */

    /* .grid-products .item .product-image {
        margin: 0 auto 0px;
    } */

    #product_name {
        font-family: var(--font-family-base);
        font-size: 16px;
    }

    /* .product-list-category {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } */

    .product-status-img {
        width: 38px !important;
        position: absolute;
        left: 0px;
        top: 0;
    }

    .no-products-found {
        font-size: 24px;
        color: #ff0000;
        font-family: Arial, sans-serif;
    }

    .no-products-found h3 {
        margin: 95px;
        margin-top: 130px;
        font-size: 36px;
        font-weight: bold;
        color: #c1c1c1;
    }



    .btn.btn-filter img {
        filter: brightness(0) invert(1);
    }

    .transferred-products,
    .purchased-products {
        font-size: 14px;
        line-height: 1.25;
    }

    /* Ensuring the container holds the tabs properly */
    .toolbar-wrapper {
        width: 100%;
        overflow: hidden;
        padding: 0;
    }

    .toolbar .view-mode .icon-mode {
        position: relative;
        display: none;
        border: 1px solid #07153d;
        margin-left: 5px;
        cursor: pointer;
        align-content: center;
        border-radius: 13px;
        font-weight: 600;
    }

    .toolbar .view-mode .icon-mode.active {
        font-size: 12px;
    }

    /* Styling the toolbar */
    .filters-toolbar-item {
        display: flex;
        justify-content: flex-start;
        flex-wrap: nowrap;
        gap: 10px;
        width: 100%;
    }

    /* Styling each tab */
    .icon-mode {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px 10px;
        transition: all 0.3s ease;
        text-align: center;

    }

    /* Adding hover effect on each tab */
    .icon-mode:hover {
        background-color: #f0f0f0;
        cursor: pointer;
        border-radius: 5px;
    }

    /* Highlight active tab */
    .icon-mode.active {
        font-weight: bold;
        color: #007bff;
    }

    input[type="checkbox"],
    input[type="radio"] {
        width: 10px;
        height: auto;
    }

    /* Responsive styling for smaller screens */
    @media (max-width: 768px) {
        .filters-toolbar-item {
            justify-content: space-between;
        }

        .icon-mode {
            flex: 1 1 30%;
        }
    }

    @media (max-width: 576px) {
        .filters-toolbar-item {
            justify-content: space-between;
        }

        .icon-mode {
            flex: 1 1 30%;
            min-width: 70px;
        }

    }

    .toolbar .view-mode .icon-mode.grid-2.active {
        width: 209px;
    }

    .product-card-column {
        padding: 10px;
        /* Horizontal and vertical spacing between cards */
    }

    .product-box {
        height: 170px;
        /* Optional: uniform height */
    }

    .product-list-main-div {
        padding-bottom: 280px;
        overflow: auto;
        height: 90vh;
    }

    /* Buyer Form Section Styling */
    #buyer-listview-loadmore {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        /* box-shadow: 0px 3px 12px rgba(0, 0, 0, 0.1); */
    }

    #buyer-listview-loadmore label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        display: flex;
        align-items: center;
        margin-bottom: 6px;
    }

    #buyer-listview-loadmore label img {
        margin-right: 8px;
    }

    /* Style only inputs and select inside the form */
    #buyer-listview-loadmore input,
    #buyer-listview-loadmore select {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
        width: 100%;
        transition: border 0.3s ease;
        background-color: #fff;
    }

    #buyer-listview-loadmore input:focus,
    #buyer-listview-loadmore select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
    }

    /* Error messages */
    #buyer-listview-loadmore #doneErrorToast,
    #buyer-listview-loadmore #quantityError,
    #buyer-listview-loadmore #priceError {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
    }
</style>