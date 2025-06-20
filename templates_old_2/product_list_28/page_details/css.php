<!--begin::Page Vendors Styles(used by this page)-->
<style>
  :root {
    --primary: #b5753e;
    --primary-light: #ffeedf;
    --text-primary: #414141;
    --text-secondary: #8f8f8f;
  }

  .h5 {
    font-weight: 550;
  }

  .gapp-5 {
    gap: 5px !important;
    justify-content: left !important;
    padding-left: 5px !important;
  }

  .active {
    background-color: var(--primary) !important;
    border-color: var(--primary) !important;
  }

  .btn-light:hover {
    background-color: var(--primary-light) !important;
  }

  .rounded-pill-list {
    font-weight: 500 !important;
    width: auto !important;
    background-color: var(--primary-light);
    border-color: var(--primary-light);
    border-radius: 50px;
  }

  .rounded-pill-list span {
    width: 100px;
  }

  .btn-filter {
    color: var(--primary);
  }

  .btn {
    margin: 0px !important;
  }

  .rounded-pill-list:hover,
  .rounded-pill-list:focus {
    background-color: var(--primary);
    border-color: var(--primary);
    opacity: 0.9;
    color: #fff !important;
  }

  .btn-light {
    background-color: var(--primary-light);
    border-color: var(--primary-light);
  }

  .text-primary {
    color: var(--primary) !important;
  }

  .list-item {
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
  }

  .list-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
  }

  .list-item .status {
    color: var(--primary);
  }

  .nav-item:hover,
  .nav-item.active {
    color: #c17f59;
    background-color: #fff !important;
  }

  .nav-link i {
    display: block;
    margin-bottom: 4px;
  }

  /* ✅ Sidebar Container */
  .sidebar {
    background-color: #f6f6f6;
    padding: 15px;
  }

  /* ✅ Sidebar Sticky Position */
  .sidebar-sticky {
    position: sticky;
    top: 0;
  }

  /* ✅ Sidebar Categories */
  .sidebar-widget {
    margin-bottom: 20px;
  }

  .sidebar-widget .widget-title h2 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  /* ✅ Sidebar Category Buttons */
  .cat-btn {
    padding: 3px 6px;
    margin: 5px 0px;
    border: 1px solid #585858;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    width: auto;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    background-color: white;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .cat-btn:hover {
    background-color: #ddd;
  }

  /* ✅ Category Button Images */
  .cat-btn img {
    width: 30px;
    height: 30px;
    object-fit: contain;
  }

  /* ✅ Category Selection Area */
  .category-div {
    padding: 5px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .category-div::-webkit-scrollbar {
    height: 8px;
  }

  .category-div::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 10px;
  }

  .category-div::-webkit-scrollbar-thumb:hover {
    background-color: #555;
  }

  /* ✅ Category Popup */
  .catgory-show-div {
    background-color: rgba(0, 0, 0, 0.8);
    width: 100%;
    min-height: 100%;
    position: absolute;
    top: 10px;
    justify-content: center;
    align-items: center;
    border-radius: 6px;
    display: none;
    padding: 20px 7px;
  }

  /* ✅ Close Button for Category Popup */
  .category-close-btn {
    color: white;
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    text-align: center;
    border-radius: 7px;
    padding: 0px 4px;
    line-height: 18px;
    cursor: pointer;
  }

  /* ✅ Sidebar Filters */
  .filters-toolbar-sort {
    width: 100%;
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: white;
    cursor: pointer;
  }

  /* ✅ Sidebar Buttons */
  .btn_danger {
    background-color: red;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
  }

  .btn_danger:hover {
    background-color: darkred;
  }

  /* ✅ Responsive Sidebar */
  @media only screen and (max-width: 767px) {
    .sidebar {
      padding: 10px;
    }

    .cat-btn {
      font-size: 10px;
      width: auto;
    }
  }

  /* ✅ Filter Tabs */
  .filter-tabs {
    white-space: nowrap;
  }

  .filter-tabs .btn {
    min-width: max-content;
  }

  /* ✅ Filter dropdown styling */
  .filters-toolbar-sort {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
  }

  /* ✅ Filter button */
  .btn_danger {
    background-color: #dc3545;
    color: white;
    padding: 10px 15px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s ease-in-out;
  }

  .btn_danger:hover {
    background-color: #c82333;
  }

  /* ✅ Responsive adjustments */
  @media (max-width: 991px) {
    .sidebar {
      padding: 15px;
    }

    .category-div {
      justify-content: center;
    }
  }

  @media (max-width: 768px) {
    .filters-toolbar-item {
      text-align: center;
    }

    .btn_danger {
      width: 100%;
    }
  }
</style>
<!--end::Page Vendors Styles-->