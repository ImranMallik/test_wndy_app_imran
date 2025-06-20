<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const dotsContainer = document.querySelector('.dots');
        const prevButton = document.querySelector('.prev');
        const nextButton = document.querySelector('.next');

        let currentSlide = 0;
        let autoSlideInterval;
        const autoSlideDelay = 1500; // 5 seconds

        // Create dots
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });

        function updateSlider() {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Update dots
            document.querySelectorAll('.dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });

            // Update slide animations
            slides.forEach((slide, index) => {
                slide.style.opacity = (index === currentSlide) ? 1 : 0;
            });

            // Show/hide navigation buttons
            prevButton.style.display = currentSlide === 0 ? 'none' : 'flex';
            nextButton.style.display = currentSlide === slides.length - 1 ? 'none' : 'flex';
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlider();
            resetAutoSlide();
        }

        function nextSlide() {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
                updateSlider();
            }
        }

        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                if (currentSlide < slides.length - 1) {
                    nextSlide();
                } else {
                    clearInterval(autoSlideInterval); // Stop auto slide after the last slide
                }
            }, autoSlideDelay);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Event listeners
        prevButton.addEventListener('click', () => {
            prevSlide();
            resetAutoSlide();
        });

        nextButton.addEventListener('click', () => {
            nextSlide();
            resetAutoSlide();
        });

        // Touch events for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        slider.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        });

        slider.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left
                    if (currentSlide < slides.length - 1) nextSlide();
                } else {
                    // Swipe right
                    if (currentSlide > 0) prevSlide();
                }
                resetAutoSlide();
            }
        }

        startAutoSlide();

        // Initial update
        updateSlider();
    });

    // show hide code start
    function sliderEnd() {
        // Select the elements
        let sliderEnd = document.querySelector('.slider-container');

        let language = document.querySelector('.language-body');

        // Hide the slider container and show the page wrapper
        sliderEnd.style.display = 'none';
        // pageWrapper.style.display = 'block';
        language.style.display = 'flex';

    }
    function showLogin() {
        let pageWrapper = document.querySelector('.page-wrapper');
        let language = document.querySelector('.language-body');

        pageWrapper.style.display = 'block';
        language.style.display = 'none';
    }

    // show hide code end

    // languageForm Start
    document.getElementById('languageForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const selectedLanguage = document.querySelector('input[name="language"]:checked');
        if (selectedLanguage) {
            console.log('Selected language:', selectedLanguage.value);

        } else {
            alert('Please select a language');
        }
    });

    // function showLogin() {
    //     window.location.href = "https://test.wndy.app/user-login";
    // }

    function showLogin() {
    window.location.href = `${baseUrl}/user-login`;
}
</script>