<link href="assets/css/dashboard-details.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css">
<!--begin::Page Vendors Styles(used by this page)-->
<!--end::Page Vendors Styles-->
<style>
    .dashboard-content {
        background-color: #f7f7f7;
        border: 1px solid #ececec;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .08);
        padding: 30px;
    }

    .bottom-btn {
        border-radius: 3px;
    }

    .btn-gray {
        background-color: #fff;
    }

    .fs-10 {
        font-size: 50px;
        padding-right: 10px;
    }

    @media only screen and (max-width: 767px) {

        .address,
        .amount,
        .order,
        .collector,
        .open-deal {
            margin-left: 120px;
        }

        .product,
        .address-two {
            margin-left: 120px;
        }
    }

    .main-itemListingChart, .main-scrapValuationChart, .main-sellerItemListingChart {
        width: 100%;
    }
    .main-scrapValuationChart {
        width: 100%;
    }
    .chart-heading{
        margin-top: 20px;
    }
</style>