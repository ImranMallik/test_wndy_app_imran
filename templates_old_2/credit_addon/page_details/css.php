<!--begin::Page Vendors Styles(used by this page)-->
<!--end::Page Vendors Styles-->
<style>
    .credit-add-on {
        padding-left: 8px;
        text-align: center;
    }

    .credit-history {
        padding-left: 8px;
        text-align: center;
    }

    .credit-table {
        display: none;
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .credit-table th,
    .credit-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .credit-table th {
        background-color: #f2f2f2;
    }

    .purchase-button {
        display: none;
    }

    .credit-btn {
        background-color: #2f415d;
        color: #fff;
        border: 1px solid #2f415d;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        border-radius: 8px;
        padding: 7px 25px;
        font-size: 14px;
        display: flex;
        margin-right: 2px;
        margin-top: 10px;
    }

    .credit-btn img {
        margin-right: 5px;
        height: 22px;
        width: 22px;
    }

    .purchase-btn {
        font-family: Poppins, sans-serif;
        background-color: #2f415d;
        color: #fff;
        border: 1px solid #2f415d;
        align-items: center;
        justify-content: center;
        width: auto;
        height: auto;
        text-align: center;
        cursor: pointer;
        border-radius: 8px;
        padding: 5px 10px;
        /* padding-right: 8px; */
        font-size: 14px;
        line-height: normal;
        white-space: normal;
        opacity: 1;
        outline: 0 !important;
        box-shadow: none !important;
        -ms-transition: 0.3s ease-in-out;
        transition: 0.3s ease-in-out;
        visibility: visible;
    }

    .purchase-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .purchase-btn img {
        margin-right: 5px;
        width: 20px;
        height: 20px;
    }

    .option-main-div {
        position: relative;
    }

    .option-div {
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        /* overflow-x: auto; */
        scroll-behavior: smooth;
        padding-bottom: 6px;
        justify-content: space-between;
    }

    .slick-prev {
        left: -19px;
        background: #ffffff7a;
        border-radius: 50%;
    }

    .slick-next {
        right: -14px;
        background: #ffffff7a;
        border-radius: 50%;
    }

    .option-div::-webkit-scrollbar {
        background: #fbfbfb;
        height: 3px;
        /* border-radius: 0px 0px 5px 5px !important; */
    }

    .option-div::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        /* border-radius: 0px 0px 5px 5px !important; */
    }

    .confirm-option-div {
        text-align: center;
        margin-top: 50px !important;
        width: fit-content;
        background: #efefef;
        margin: auto;
        padding: 13px;
        border-radius: 7px;
        box-shadow: 1px 3px 7px 0px #7f7f7f;
    }

    @media only screen and (max-width: 768px) {
        .toolbar .view-mode .icon-mode.grid-3, .toolbar .view-mode .icon-mode.credit-history {
            margin-left: 5px !important;
        }
    }
</style>