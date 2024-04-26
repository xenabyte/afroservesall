$(document).ready(function(){
    var imageUrls = [
        "../assets/images/services/s5.jpg",
        "../assets/images/services/s3.jpg",
        "../assets/images/services/s1.jpg",
        // Add more image URLs as needed
    ];

    var heroSection = $('.hero-section');
    var overlay = $('.bg-overlay');

    var index = 0;
    var img = new Image();
    img.onload = function() {
        overlay.fadeOut(50, function() {
            heroSection.css('background-image', 'url(' + imageUrls[index] + ')');
            overlay.show();
        });
    };
    img.src = imageUrls[index];

    setInterval(function(){
        index = (index + 1) % imageUrls.length;
        overlay.fadeIn(500, function() {
            var nextImg = new Image();
            nextImg.onload = function() {
                heroSection.css('background-image', 'url(' + imageUrls[index] + ')');
            };
            nextImg.src = imageUrls[index];
        });
    }, 5000); // Change image every 5 seconds
});