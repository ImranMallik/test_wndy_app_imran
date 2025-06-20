<link href="assets/css/dashboard-details.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css">
<!--begin::Page Vendors Styles(used by this page)-->
<!--end::Page Vendors Styles-->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }


    .font-size {
        font-size: 25px;
    }

    .status-bar {
        display: flex;
        justify-content: space-between;
        padding: 10px 15px;
        font-weight: 600;
    }

    .status-bar-right {
        display: flex;
        gap: 8px;
    }

    /* .container {
        padding: 20px;
    } */

    .welcome {
        /* font-size: 28px; */
        font-weight: bold;
        margin-bottom: 8px;
        font-size: 23px;
    }

    .section-title {
        font-size: 18px;
        margin-bottom: 6px;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 24px;
    }

    .card {
        background-color: #E6C9A8;
        border-radius: 15px;
        padding: 10px;
        position: relative;
        min-height: 140px;
    }

    .card-number {
        font-size: 25px;
        font-weight: bold;
        color: white;
        background-color: #B17B4F;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50px 50px 40px 25px;
        left: 0px;
        position: absolute;
        bottom: 0px;
    }

    .card-title {
        color: white;
        font-size: 18px;
        margin-top: 10px;
    }

    .icon-db {
        width: 80px;
        right: 0;
        position: absolute;
        bottom: 0;
    }

    .icon-db-open-item {
        width: 90px;
        right: 0;
        position: absolute;
        bottom: 0;
    }

    .icon-db-under-nego {
        width: 85px;
        right: 10px;
        position: absolute;
        bottom: 1px;
    }

    .icon-db-close-item {
        width: 65px;
        right: 0;
        position: absolute;
        bottom: 0;
    }

    .total-items {
        border: 2px solid #B17B4F;
        border-radius: 25px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-size: 24px;
        font-weight: bold;
    }

    .progress-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 60px;
    }

    .progress-card {
        background-color: #E6C9A8;
        border-radius: 15px;
        padding: 20px 0px 20px 0px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .progress-circle {
        width: 80px;
        height: 80px;
        position: relative;
    }

    .progress-circle-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 18px;
        color: white;
    }

    .progress-title {
        color: white;
        text-align: center;
        font-size: 14px;
    }

    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        padding: 10px;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #666;
        text-decoration: none;
    }

    .add-button {
        width: 50px;
        height: 50px;
        background: #B17B4F;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-top: -20px;
    }



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

    .main-itemListingChart,
    .main-scrapValuationChart,
    .main-sellerItemListingChart {
        width: 100%;
    }

    .main-scrapValuationChart {
        width: 100%;
    }

    .chart-heading {
  margin-top: 1px;
  margin-left: 10px;
}
</style>