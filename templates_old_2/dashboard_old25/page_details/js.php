<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="templates/dashboard/controller.js?v=<?php echo $version; ?>"></script>
<script>

    $(".open-items-link").on("click", function (e) {
        // alert();
        e.preventDefault();
        localStorage.setItem("selectedFilter", "Active"); 
        window.location.href = "<?php echo $baseUrl . '/product_list'; ?>"; 
        
    });
    
    
    function setFilterUnderNegotiation(event,filter){
        // alert();
            event.preventDefault(); 
            localStorage.setItem("selectedFilter", filter); 
            window.location.href = "<?php echo $baseUrl . '/product_list'; ?>"; 

    }
    
    function setFilterClosedItem(event,filter){
        event.preventDefault(); 
            localStorage.setItem("selectedFilter", filter); 
            window.location.href = "<?php echo $baseUrl . '/product_list'; ?>"; 
    }
    function sellerTotalItems(event,filter){
        event.preventDefault(); 
            localStorage.setItem("selectedFilter", filter); 
            window.location.href = "<?php echo $baseUrl . '/product_list'; ?>"; 
    }
    
    
  


</script>
