// Function untuk animate.css, digunakan untuk memanggil animasi melalui javascript, ex: animateCSS('.my-element', 'bounce');
const animateCSS = (element, animation, speed, prefix = 'animate__') =>
    // We create a Promise and return it
    new Promise((resolve, reject) => {
        const animationName = `${prefix}${animation}`;
        const animationSpeed = `${prefix}${speed}`;

        $(element).each(function () {
            this.classList.add(`${prefix}animated`, animationName, animationSpeed);
        });

        // When the animation ends, we clean the classes and resolve the Promise
        function handleAnimationEnd(event) {
            event.stopPropagation();
            $(element).each(function () {
                this.classList.remove(`${prefix}animated`, animationName, animationSpeed);
            });
            resolve('Animation ended');
        }

        $(element).each(function () {
            this.addEventListener('animationend', handleAnimationEnd, {once: true});
        });
    });

// Function alert
function showAlert(message, type) {
    $('#alert-container').append('<div class="alert alert-' + type + ' alert-dismissible animate__animated animate__fadeInDown animate__faster">'
            + message +
            '<button type="button" id="close-alert-button" class="btn-close"></button>');

    // Alert terbaru selalu index terbesar
    var alertClassIndex = document.getElementsByClassName('alert').length - 1;

    // Hide alert setelah 5 detik
    setTimeout(function () {
        hideAlert(document.getElementsByClassName('alert')[alertClassIndex]);
    }, 5000);
}

function hideAlert(targetAlert) {
    animateCSS(targetAlert, 'fadeOutUp', 'faster').then(function () {
        $(targetAlert).css('display', 'none');
    });
}

// Tombol close alert
$(document).ready(function () {
    $('#alert-container').on('click', '#close-alert-button', function (event) {
        var alert = event.target.parentNode;
        hideAlert(alert);
    });
});

// Set width alert mengikuti parent
$(document).ready(function () {
    // Width awal
    var alertWidth = $('#alert-container').parent().width();
    $('#alert-container').css('width', alertWidth);

    // Width saat resize
    window.addEventListener('resize', function () {
        alertWidth = $('#alert-container').parent().width();
        $('#alert-container').css('width', alertWidth);
    });
});