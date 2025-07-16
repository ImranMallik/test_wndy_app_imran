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

    .product-div {
        margin-bottom: 20px !important;
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

    .col-item {
        background-color: #f6f6f6;
        width: 100%;
        padding-top: 0px !important;
        margin-bottom: 4px;
    }

    .grid-products .item .product-image {
        margin: 0 auto 0px;
    }

    #product_name {
        font-family: var(--font-family-base);
        font-size: 16px;
    }

    .product-list-category {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-status-img {
        width: 38px !important;
        position: absolute;
        left: 0px;
        top: 0;
    }

    .modal-header {
        display: block;
    }

    .modal-title {
        margin-bottom: 0;
    }

    .modal-header span {
        display: inline-block;
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

    .toolbar .view-mode .icon-mode.active {
        font-size: 12px;
    }

    /* image icon color change */
    .btn.btn-filter img {
        filter: brightness(0) invert(1);
    }

    .transferred-products,
    .purchased-products {
        font-size: 14px;
        line-height: 1.25;
    }

    .toolbar .view-mode .icon-mode {
        min-width: 168px;
    }

    .product-item {
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .product-item:hover {
        transform: scale(1.05);
    }


    .product-item {
        position: relative;
        border-radius: 11%;
        width: 100px;
        height: 145px;
        overflow: hidden;
        background-image: url('frontend_assets/img-icon/received.png');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        margin: auto;
        margin-bottom: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
        background-color: #dddee2;
    }


    .product-item:hover {
        transform: scale(1.1);
    }

    .product-count {
        position: absolute;
        top: 5%;
        right: 5%;
        background-color: rgba(255, 0, 0, 0.85);
        color: white;
        font-size: 14px;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .product-name {
        font-weight: 600;
        margin-top: 10px;
        text-align: center;
    }




    .img-fluid {
        max-height: 250px;
        object-fit: cover;
    }

    .text-primary {
        color: #4facfe !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .product-rating span {
        font-size: 1.2rem;
    }


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

    .filters-toolbar-item {
        display: flex;
        justify-content: flex-start;
        flex-wrap: nowrap;
        gap: 10px;
        width: 100%;
    }

    .icon-mode {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px 10px;
        transition: all 0.3s ease;
        text-align: center;

    }

    .icon-mode:hover {
        background-color: #f0f0f0;
        cursor: pointer;
        border-radius: 5px;
    }


    .icon-mode.active {
        font-weight: bold;
        color: #007bff;
    }

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

    body {
        position: relative;
        min-height: 100%;
        top: 0px;
        overflow: hidden;
        padding-right: 0px !important;

    }

    .custom-scroll {
        max-height: 500px;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
        padding-right: 10px;
        position: relative;
    }

    .custom-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    .toolbar .view-mode .icon-mode.grid-2.active {
        width: 209px;
    }

    .no-products-found {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
        width: -webkit-fill-available;
        font-family: Arial, sans-serif;
        text-align: center;
        color: #ff0000;
    }

    .no-products-found h3 {
        margin: 0;
        font-size: 36px;
        font-weight: bold;
        color: #c1c1c1;
    }

    .product-list-main-div {
        padding-bottom: 140px;
        overflow: auto;
        height: 90vh;
    }
</style>
<!--end::Page Vendors Styles-->