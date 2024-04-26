
$(document).ready(function(){
    var imageUrls = [
        "../assets/images/services/f1.jpg",
        "../assets/images/services/food1.png",
        "../assets/images/services/food2.png",
        "../assets/images/services/f2.jpg",
        "../assets/images/services/food4.png",
        "../assets/images/services/f3.jpg",
        "../assets/images/services/food5.png",
        "../assets/images/services/food3.png",
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