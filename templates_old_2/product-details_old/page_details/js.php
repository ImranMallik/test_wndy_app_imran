<script src="assets/js/vendor/jquery.elevatezoom.js?v=<?php echo $version; ?>"></script>
<script src="templates/product-details/controller.js?v=<?php echo $version; ?>"></script>
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
    </script>

<script src="assets/js/vendor/photoswipe.min.js?v=<?php echo $version; ?>"></script>

