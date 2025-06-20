<style>
      :root {
            --primary-color: #c17f59;
        }

        .status-bar {
            background-color: #fff;
            padding: 10px 15px;
            font-size: 0.8rem;
            color: #000;
        }

        .header {
            padding: 15px;
            background-color: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .back-button {
            color: #000;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .transaction-item {
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .amount {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .amount.positive {
            color: #000;
        }

        .description {
            color: #666;
            font-size: 0.9rem;
        }

        .date {
            color: #666;
            font-size: 0.8rem;
        }

        /* Bottom Navigation Styles */
        .nav-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #666;
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.3s;
        }

        .nav-item:hover,
        .nav-item.active {
            color: var(--primary-color);
        }

        .nav-item i {
            font-size: 1.3rem;
            margin-bottom: 4px;
        }

        .add-button {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-top: -35px;
            box-shadow: 0 2px 10px rgba(193, 127, 89, 0.3);
            transition: transform 0.3s;
        }

        .add-button:hover {
            transform: scale(1.1);
            color: white;
        }
</style>