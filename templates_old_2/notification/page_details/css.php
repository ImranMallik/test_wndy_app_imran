<style>
    body {
        background-color: #ffffff;
        font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .notification-header {
        padding: 5px 0px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        background: white;
        z-index: 100;
        margin-bottom: 10px;
    }

    .header-icons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .notification-card {
        background-color: #ffeedf !important;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
    }

    .notification-time {
        color: #666;
        font-size: 0.9rem;
    }

    .notification-text {
        color: #666;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .date-separator {
        margin: 20px 0 15px 0;
        color: #333;
        font-weight: 500;
    }

    .notification-count {
        color: #ff6b00;
    }

    .system-header {
        background: #f8f8f8;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .profile-icon {
        width: 32px;
        height: 32px;
        background: #f0f0f0;
        border-radius: 50%;
    }

    @media (min-width: 768px) {
        .container {
            max-width: 600px;
        }
    }
</style>