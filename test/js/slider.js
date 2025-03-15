// Initialize Swiper
const swiper = new Swiper('.custom_slider', {
    loop: true, // Enable looping
    pagination: {
        el: '.swiper-pagination',
        clickable: true, // Allow clicking on pagination bullets
    },
    navigation: {
        nextEl: '.swiper-button-next', // Next button
        prevEl: '.swiper-button-prev', // Previous button
    },
    autoplay: {
        delay: 5000, // Delay between slides in milliseconds
        disableOnInteraction: false, // Continue autoplay after user interactions
    },
    effect: 'slide', // Transition effect
    speed: 600, // Transition speed
});

// Optional: Add event listeners for additional functionality
swiper.on('slideChange', function () {
    console.log('Slide changed to: ' + swiper.activeIndex);
});