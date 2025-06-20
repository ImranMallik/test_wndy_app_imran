<?php
$currentPage = basename($_SERVER['REQUEST_URI']); // Current page name
?>


<style>
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
        color: #c17f59;
    }

    .nav-item i {
        font-size: 1.3rem;
        margin-bottom: 4px;
    }

    .add-button {
        width: 50px;
        height: 50px;
        background: #c17f59;
        border-radius: 50%;
        display: flex;
        top: 1rem;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 2px 10px rgba(193, 127, 89, 0.3);
        transition: transform 0.3s;
    }

    

    body {
        min-height: 100vh;
        background: #f5f5f5;
    }
</style>



    <div class="nav-container">
        <div class="container">
            <div class="row justify-content-around align-items-center">
                <div class="col-2 text-center">
                    <a href="dashboard" class="nav-item <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </div>
                <div class="col-2 text-center">
                    <a href="deal-items" class="nav-item <?php echo ($currentPage == 'deal-items') ? 'active' : ''; ?>">
                        <i class="bi bi-graph-up"></i>
                        <span>My Items</span>
                    </a>
                </div>
                <div class="col-2 text-center">
                    <a href="seller-post-category" class="add-button">
                        <i class="bi bi-plus"></i>
                    </a>
                </div>
                <div class="col-2 text-center">
                    <a href="address-book" class="nav-item <?php echo ($currentPage == 'address-book') ? 'active' : ''; ?>">
                        <i class="bi bi-geo-alt"></i>
                        <span>Addresses</span>
                    </a>
                </div>
                <div class="col-2 text-center">
                    <a href="my-account" class="nav-item <?php echo ($currentPage == 'my-account') ? 'active' : ''; ?>">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

