<style>
        body {
            background-color: #f8f9fa;
            max-width: 480px;
            margin: 0 auto;
        }

        .wallet-header {
            background: linear-gradient(135deg, #C17533 0%, #D4965B 100%);
            color: white;
            padding: 40px 20px;
            border-radius: 0 0 25px 25px;
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 15px;
            left: 15px;
            color: white;
            font-size: 20px;
        }

        .wallet-balance {
            text-align: center;
        }

        .balance-title {
            font-size: 18px;
            opacity: 0.9;
        }

        .balance-amount {
            font-size: 32px;
            font-weight: bold;
            margin-top: 10px;
        }

        .recommended-amounts {
            display: flex;
            gap: 10px;
            margin: 15px 0;
        }

        .amount-chip {
            border: 1px solid #C17533;
            color: #C17533;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
        }

        .add-credit-btn {
            background: #C17533;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .transaction-history {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            color: #333;
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

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }
    </style>


<link href="frontend_assets/assets/global/plugins/icheck/skins/all.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />