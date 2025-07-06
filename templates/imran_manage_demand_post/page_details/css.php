<!--begin::Page Vendors Styles(used by this page)-->
<style>
  :root {
    --primary: #b5753e;
    --primary-light: #ffeedf;
    --text-primary: #414141;
    --text-secondary: #8f8f8f;
  }

  .dropdown-icon {
    margin-left: -21px;
    color: #333;
    margin-top: -26px;
    position: fixed;
  }

  .f-500 {
    font-weight: 1000 !important;
  }

  .bi-chevron-down::before {
    font-weight: 1000 !important;
  }

  .custom-select-wrapper {
    position: relative;
    width: 100%;
    border: 0.5px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
  }

  .custom-select {
    border: 0.7px solid #ddd;
    padding: 10px;
    cursor: pointer;
    background: #fff;
    border-radius: 5px;
    text-align: left;
  }

  .custom-options {
    position: absolute;
    width: 100%;
    max-height: 350px;
    overflow-y: auto;
    border: 1px solid #ccc;
    background: #fff;
    display: none;
    z-index: 1000;
  }

  .custom-options div {
    padding: 5px 10px;
    cursor: pointer;
    text-align: left;
  }

  .custom-options div:hover {
    background-color: #f0f0f0;
  }

  .custom-search {
    border-bottom: 1px solid #ccc !important;
    border: none;
    padding: 8px;
    width: 100%;
    box-sizing: border-box;
    outline: none;
    position: sticky;
    top: 0;
    border-radius: 0px;
  }

  .btn-filter {
    color: var(--primary);
  }

  .btn {
    margin: 0px !important;
  }

  .sidebar {
    background-color: #f6f6f6;
    padding: 15px;
  }

  .sidebar-sticky {
    position: sticky;
    top: 0;
  }

  .sidebar.filterbar {
    display: none;
  }

  .sidebar.filterbar.active {
    display: block;
    z-index: 9999;
    background: #fff;
  }

  .filters-toolbar-item {
    text-align: center;
  }

  .demand-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
  }

  .icon-btn {
    width: 24px;
    height: 24px;
    object-fit: contain;
  }

  .modal-footer {
    padding: 15px 20px;
    background-color: #f9f9f9;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .modal-footer .btn-primary {
    background-color: #0571ae;
    color: white;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 4px;
    transition: background-color 0.3s ease-in-out;
  }

  .modal-footer .btn-primary:hover {
    background-color: #011423;
  }

  .modal-footer .btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 4px;
    transition: background-color 0.3s ease-in-out;
  }

  .modal-footer .btn-secondary:hover {
    background-color: #5a6268;
  }
</style>
<!--end::Page Vendors Styles-->