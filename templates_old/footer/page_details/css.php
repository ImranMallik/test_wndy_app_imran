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

    .add-button:hover {
        transform: scale(1.1);
        color: white;
    }

    body {
        min-height: 100vh;
        background: #f5f5f5;
    }
</style>