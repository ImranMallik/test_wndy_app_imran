<!-- Body Container -->
<?php
$product_status = $arr[2];
?>
<div id="page-content" class="mb-0">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-12 col-sm-12 col-md-12 col-lg-3 sidebar sidebar-bg filterbar">
        <div class="closeFilter d-block d-lg-none"><i class="icon anm anm-times-r"></i></div>
        <div class="sidebar-tags sidebar-sticky clearfix">
          <div class="widget-title" style="background-color: #f8f9fa !important;">
            <h2>Choose Categories</h2>
          </div>
          <div class="col-12 col-sm-12 col-md-10 col-lg-10 text-right filters-toolbar-item order-2 order-sm-2" style="padding:10px;">
            <div class="row">
              <div class="col-12">
                <div class="custom-select-wrapper">
                  <div class="custom-select" onclick="toggleCategoryOptions()">Select Category</div>
                  <span class="dropdown-icon"><i class="bi bi-chevron-down f-500"></i></span>

                  <div class="custom-options" id="customCategoryOptions">
                    <input type="text" class="custom-search" placeholder="Search..." onkeyup="filterCategoryOptions(this.value)">
                    <div onclick="selectCategoryOption(this, 'All')">All Categories</div>
                    <?php
                    $fetchData = mysqli_query($con, "
        SELECT DISTINCT cm.category_id, cm.category_name 
        FROM tbl_category_master cm
        INNER JOIN tbl_demand_post dp 
        ON cm.category_id = dp.category_id
        ORDER BY cm.category_name ASC
      ");
                    while ($row = mysqli_fetch_array($fetchData)) {
                      $catId = $row['category_id'];
                      $catName = htmlspecialchars($row['category_name']);
                      echo "<div onclick=\"selectCategoryOption(this, '$catId')\">$catName</div>";
                    }
                    ?>
                    <div id="noCategoryResult" style="display: none; padding: 10px; color: #999; font-style: italic;">No results found</div>
                  </div>

                  <select id="category_id" style="display:none;" onchange="get_demand_post_list_category()">
                    <option value="All">All Categories</option>
                    <?php
                    mysqli_data_seek($fetchData, 0);
                    while ($row = mysqli_fetch_array($fetchData)) {
                      echo "<option value=\"{$row['category_id']}\">" . htmlspecialchars($row['category_name']) . "</option>";
                    }
                    ?>
                  </select>
                  <div id="errorToast" style="color: red; font-size: 12px; display: none; padding: 3px 0;">
                    Please select a category.
                  </div>
                </div>
              </div>

            </div>
            <br>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-12 col-sm-12 col-md-12 col-lg-9 main-col">
        <div class="toolbar toolbar-wrapper shop-toolbar">
          <div class="row align-items-center mt-2">
            <div class="col-12 d-flex justify-content-between align-items-center">
              <div class="row w-100"></div>
            </div>
          </div>
        </div>

        <div class="fixed-top bg-white">
          <div class="d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
              <a href="dashboard" class="text-dark">
                <i class="bi bi-arrow-left fs-5"></i>
              </a>
              <h1 class="mb-0 fs-4 fw-bold text-dark">Demand Post List</h1>
            </div>
            <i class="bi bi-sliders fs-5 btn-filter"></i>
          </div>
        </div>

        <div class="product-listview-loadmore">
          <div class="pt-2 mt-5 pb-3 px-3">
            <!-- Injected Product Grid Starts Here -->
            <div class="product-grid" style="margin-top: 20px;" id="product-grid">
              <?php
              $query = "
    SELECT 
        dp.demand_post_id, 
        dp.demand_post_name, 
        dp.category_id, 
        cm.category_name, 
        dp.brand, 
        dp.quantity_pcs, 
        dp.quantity_kg
    FROM tbl_demand_post dp
    INNER JOIN tbl_category_master cm 
        ON dp.category_id = cm.category_id
    WHERE dp.demand_post_status = 'active'
    ORDER BY dp.demand_post_id DESC
";

              $result = mysqli_query($con, $query);

              if (mysqli_num_rows($result) > 0) {
                while ($rw = mysqli_fetch_assoc($result)) {

                  $quantityDisplay = '';
                  if (!empty($rw['quantity_pcs'])) {
                    $quantityDisplay = htmlspecialchars($rw['quantity_pcs']);
                  } elseif (!empty($rw['quantity_kg'])) {
                    $quantityDisplay = htmlspecialchars($rw['quantity_kg']);
                  }

                  echo '
<div class="demand-card mb-3">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <h5 class="mb-1 fw-bold">' . htmlspecialchars($rw['demand_post_name']) . '</h5>
      <div class="text-secondary small">Category: ' . htmlspecialchars($rw['category_name']) . '</div>
      <div class="text-secondary small">Brand: ' . htmlspecialchars($rw['brand']) . '</div>
      <div class="text-secondary small">Quantity: ' . $quantityDisplay . '</div>
    </div>

    <div class="d-flex align-items-start gap-2">
      <!-- Edit Button -->
      <a href="#"
        data-bs-toggle="modal"
        data-bs-target="#editModal"
        onclick="populateEditModal(
          ' . $rw['demand_post_id'] . ',
          \'' . htmlspecialchars($rw['demand_post_name'], ENT_QUOTES) . '\',
          \'' . htmlspecialchars($rw['category_id'], ENT_QUOTES) . '\',
          \'' . htmlspecialchars($rw['brand'], ENT_QUOTES) . '\',
          \'' . htmlspecialchars($rw['quantity_pcs'], ENT_QUOTES) . '\',
          \'' . htmlspecialchars($rw['quantity_kg'], ENT_QUOTES) . '\'
        )"
        title="Edit">
        <img src="frontend_assets/img-icon/edit.png" alt="Edit" class="icon-btn">
      </a>

      <!-- Delete Button -->
      <a href="javascript:void(0);" title="Delete" onclick="delete_alert(' . $rw['demand_post_id'] . ', event);">
        <img src="frontend_assets/img-icon/bin.png" alt="Delete" class="icon-btn">
      </a>
    </div>
  </div>
</div>';
                }
              } else {
                echo '<div style="text-align: center; color: #666; padding: 20px;">No posts found.</div>';
              }
              ?>
            </div>

            <!-- Injected Product Grid Ends Here -->
          </div>
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Demand Post</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="editForm">
                    <!-- Demand Post Name -->
                    <div class="mb-3">
                      <label for="editDemandPostName" class="form-label">Demand Post Name</label>
                      <input type="text" class="form-control" id="editDemandPostName" name="demand_post_name" required>
                    </div>

                    <div class="mb-3">
                      <label for="editCategoryId" class="form-label">Category</label>
                      <select class="form-control" id="editCategoryId" name="category_id" required>
                        <option value="">Choose Category</option>
                        <?php
                        // Fetch unique categories from tbl_category_master
                        $fetchCategories = mysqli_query($con, "
            SELECT DISTINCT cm.category_id, cm.category_name 
            FROM tbl_category_master cm
            INNER JOIN tbl_demand_post dp 
            ON cm.category_id = dp.category_id
        ");
                        while ($category = mysqli_fetch_array($fetchCategories)) {
                          echo "<option value='" . $category['category_id'] . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                        }
                        ?>
                      </select>
                    </div>


                    <!-- Brand -->
                    <div class="mb-3">
                      <label for="editBrand" class="form-label">Brand</label>
                      <input type="text" class="form-control" id="editBrand" name="brand" required>
                    </div>

                    <div class="mb-3">
                      <label for="editQuantity" class="form-label">Quantity(Pieces)</label>
                      <input type="text" class="form-control" id="editQuantitypcs" name="quantity_pcs" required>
                    </div>
                    <div class="mb-3">
                      <label for="editQuantity" class="form-label">Quantity(Kg)</label>
                      <input type="text" class="form-control" id="editQuantitykg" name="quantity_kg" required>
                    </div>

                    <input type="hidden" id="editDemandPostId" name="demand_post_id">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" onclick="submitEditForm()">Save Changes</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>