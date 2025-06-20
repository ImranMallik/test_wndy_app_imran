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

    @media only screen and (max-width: 767px) {
        .swal2-popup {
            /* display: none; */
            position: relative !important;
            box-sizing: border-box !important;
            flex-direction: column !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 100% !important;
            padding-bottom: 2em !important;
            border: none !important;
            border-radius: 10px !important;
            background: #fff !important;
            font-family: inherit !important;
            font-size: 1em !important;
        }

        .swal2-container {
            display: flex !important;
            position: fixed !important;
            z-index: 1060 !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2em !important;
            overflow-x: hidden !important;
            transition: background-color .1s !important;
            -webkit-overflow-scrolling: touch !important;
        }
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

    .address-wrap {
        word-wrap: break-word;
    }

    #suggestions {
        position: absolute;
        background: #fff;
        z-index: 1000;
        width: 91%;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .suggestion-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .suggestion-item:hover {
        background-color: #f9f9f9;
    }
</style>