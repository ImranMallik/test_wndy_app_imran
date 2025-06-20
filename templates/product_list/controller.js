$(document).ready(function () {
    let page = 1;
       let loading = false;
       let statusFilter = "all"; // Default filter should be 'all'
       
         const stored = localStorage.getItem("clicked_product_id");
       if (stored) {
           const data = JSON.parse(stored);
           const now = new Date().getTime();
   
      if (now < data.expiry) {
      
       setTimeout(function () {
           getProductListSellerList(data.value);
       }, 3);
   }
   
   
   
           localStorage.removeItem("clicked_product_id");
       }
   
       // Check if there is a stored filter in localStorage
       const storedFilter = localStorage.getItem("selectedFilter");
       if (storedFilter) {
           statusFilter = storedFilter; // Use stored filter
           localStorage.removeItem("selectedFilter"); // Clear stored value after applying
       }
   
       // ✅ Highlight the correct filter button at the start
       $(".filter-btn").removeClass("active btn-primary").addClass("btn-light text-primary");
       $(".filter-btn[data-filter='" + statusFilter + "']")
           .addClass("active btn-primary")
           .removeClass("btn-light text-primary");
   
       // ✅ Ensure AJAX is triggered for the default "All" filter
       fetchProducts(statusFilter, page);
   
       // ✅ Handle Filter Click
       $(".filter-btn").on("click", function () {
           statusFilter = $(this).attr("data-filter");
   
           $(".filter-btn").removeClass("active btn-primary").addClass("btn-light text-primary");
           $(this).addClass("active btn-primary").removeClass("btn-light text-primary");
   
           page = 1; // Reset page
           fetchProducts(statusFilter, page);
       });
   
       // ✅ Load More Button Click
       $(document).on("click", "#loadMore", function () {
           page++;
           fetchProducts(statusFilter, page);
       });
   
       function fetchProducts(status, page) {
           if (loading) return;
           loading = true;
   
           $.ajax({
               url: "templates/product_list/filter_status_wise_product.php",
               type: "POST",
               data: { product_status: status, page: page },
               beforeSend: function () {
                   if (page === 1) {
                       $("#product_list").html('<div class="text-center"><img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" /></div>');
                   }
                   $("#loadMore").text("Loading...").prop("disabled", true);
               },
               success: function (response) {
                   if ($.trim(response) !== "") {
                       if (page === 1) {
                           $("#product_list").html(response); // Replace content
                       } else {
                           $("#product_list").append(response); // Append for pagination
                       }
   
                       // Show Load More button if there are products
                       if (response.includes("list-item")) {
                           $("#loadMore").show().text("Load More").prop("disabled", false);
                       } else {
                           $("#loadMore").hide();
                       }
                   } else {
                       if (page === 1) {
                           $("#product_list").html('<div class="text-center"><h3>No products found</h3></div>');
                       }
                       $("#loadMore").hide();
                   }
   
                   loading = false;
               },
               error: function (xhr, status, error) {
                   console.error("AJAX Error:", error, xhr.responseText);
                   $("#product_list").html("<div class='text-center'><p class='text-danger'>Error loading products. Please try again.</p></div>");
                   $("#loadMore").hide();
                   loading = false;
               }
           });
       }
   
   });
   
   
   



function clear_filter() {
    // Reset filter inputs
    _("#pincode").value = "All";
    _("#landmark").value = "All";
    _("#seller_id").value = ""; // Reset hidden select
    _("#product_status").value = "";

    // Reset custom seller dropdown display
    document.querySelector('.custom-select').innerText = "Select Seller";

    // Hide the seller dropdown list if open
    document.getElementById("customOptions").style.display = "none";
    closeCategory();
}

   
   
   
   let category_id = "";
   
   function getLandmark() {
       _(".background_overlay").style.display = "block";
       let data = new FormData();
       const sendData = {
           pincode: _("#pincode").value,
       };
       data.append("sendData", JSON.stringify(sendData));
   
       landmarkXhr = new XMLHttpRequest();
       landmarkXhr.onreadystatechange = function () {
           if (landmarkXhr.readyState == 4) {
               // console.log(landmarkXhr.responseText);
               _("#landmark").innerHTML = landmarkXhr.responseText;
               getProductList();
               _(".background_overlay").style.display = "none";
           }
       }
       landmarkXhr.open('POST', 'templates/product_list/get_landmark_select_list.php', true);
       landmarkXhr.send(data);
   }
   
   function selectCategory(cate_rw) {
       _(".main-cate-btn").innerHTML = _(".cate_btn_" + cate_rw).innerHTML;
       _(".main-cate-btn").classList.remove("animate__bounceOut");
       _(".main-cate-btn").classList.add("animate__bounceIn");
       _(".catgory-show-div").style.display = "flex";
       category_id = _(".cate_btn_" + cate_rw).getAttribute("data-category_id");
       getProductList();
   }
   
   function closeCategory(params) {
       _(".main-cate-btn").innerHTML = '';
       _(".main-cate-btn").classList.remove("animate__bounceIn");
       _(".main-cate-btn").classList.add("animate__bounceOut");
       setTimeout(function () {
           _(".catgory-show-div").style.display = "none";
       }, 500);
       category_id = '';
       getProductList();
   }
   
   function getProductList() {
       _("#product_list").innerHTML = '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';
       let data = new FormData();
       const sendData = {
           pincode: _("#pincode").value,
           landmark: _("#landmark").value,
           city: _("#city").value,
           seller_id:_("#seller_id").value,
           category_id: category_id,
       };
       data.append("sendData", JSON.stringify(sendData));
       console.log(sendData);
       xhr = new XMLHttpRequest();
       xhr.onreadystatechange = function () {
           if (xhr.readyState == 4) {
   // 			console.log(xhr.responseText);
               _(".loder-button").style.display = "none"
               _("#product_list").innerHTML = xhr.responseText;
   // 			_("#product_list").innerHTML = '<h1>SORRY</h1>';
               _(".background_overlay").style.display = "none";
               
               
           }
       }
       xhr.open('POST', 'templates/product_list/get_product_list.php', true);
       xhr.send(data);
   }
   
   function toggleRecentPosts() {
       // Get the elements by ID
       var productList = document.getElementById("product_list");
       var recentPostList = document.getElementById("recent_post_list");
       var recentPostContainer = document.getElementById("recent_post_container");
   
       if (recentPostContainer.style.display === "none") {
           recentPostContainer.style.display = "block";
           productList.style.display = "none";
       } else {
           recentPostContainer.style.display = "none";
           productList.style.display = "block";
       }
   
   }
   
   
   // Seller list Product
   function getProductListSellerList(product_id) {
       // _("#product_list").innerHTML = '<img class="preloader_img" src="frontend_assets/assets/layouts/layout/img/ajax-modal-loading.gif" />';
   
       let data = new FormData();
       data.append("product_id", product_id);
   
       const xhr = new XMLHttpRequest();
       xhr.onreadystatechange = function () {
           if (xhr.readyState == 4) {
               _(".loder-button").style.display = "none";
               _("#product_list").innerHTML = xhr.responseText;
               _(".background_overlay").style.display = "none";
           }
       };
   
       xhr.open('POST', 'templates/product_list/get_product_list.php', true);
       xhr.send(data);
   }
   
   
     function closeSidebar() {
       const sidebar = document.querySelector('.sidebar.filterbar');
       if (sidebar) {
         sidebar.classList.remove('active');
       }
     }
   
     function openSidebar() {
       const sidebar = document.querySelector('.sidebar.filterbar');
       if (sidebar) {
         sidebar.classList.add('active');
       }
     }
   
     document.addEventListener("DOMContentLoaded", function () {
       // Handle close cross (x)
       const closeBtn = document.querySelector('.closeFilter');
       if (closeBtn) {
         closeBtn.addEventListener('click', closeSidebar);
       }
   
       // Handle filter icon
       const openBtn = document.querySelector('.btn-filter');
       if (openBtn) {
         openBtn.addEventListener('click', openSidebar);
       }
   
       // Handle Done button
       const doneBtn = document.querySelector('.filter-btn-clear-done');
       if (doneBtn) {
         doneBtn.addEventListener('click', closeSidebar);
       }
     });
     
     
     
   
   
   
  