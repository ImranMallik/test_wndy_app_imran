<script src="assets/js/vendor/jquery.elevatezoom.js?v=<?php echo $version; ?>"></script>
<script src="templates/product-details/controller.js?v=<?php echo $version; ?>"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var withdrawModal = new bootstrap.Modal(document.getElementById('withdrawModal'));
    withdrawModal.show();
  });
  
  

</script>

<script>
function redirectWithProductId(button) {
    const productId = button.getAttribute('data-product-id');
    
    // Store productId and expiry time (now + 60 seconds)
    const expiry = new Date().getTime() + 60 * 1000;
    const data = { value: productId, expiry: expiry };

    localStorage.setItem("clicked_product_id", JSON.stringify(data));
    
    // Redirect to product list
    window.location.href = "<?= $base_url; ?>/product_list";
}

</script>

<script>
        // Initialize carousel
        const carousel = new bootstrap.Carousel(document.getElementById('productCarousel'), {
            interval: 3000
        });

        // Update slide counter
        const carouselElement = document.getElementById('productCarousel');
        const currentSlideElement = document.getElementById('currentSlide');

        carouselElement.addEventListener('slid.bs.carousel', function (event) {
            const activeSlide = event.to + 1;
            currentSlideElement.textContent = activeSlide;
        });
        
        document.addEventListener("DOMContentLoaded", function () {
    // Ensure the modal exists in the DOM before running script
    var confirmBoxModal = document.getElementById('confirmBoxModal');

    if (!confirmBoxModal) {
        console.error("Modal element #confirmBoxModal not found!");
        return;
    }

    window.toggleConfirmBox = function () {
        var modalInstance = new bootstrap.Modal(confirmBoxModal);
        modalInstance.show();
    };
    
    // Show text field when 'Other' is selected

});
    </script>

<script src="assets/js/vendor/photoswipe.min.js?v=<?php echo $version; ?>"></script>

