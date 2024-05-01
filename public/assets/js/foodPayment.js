// Smooth scroll to accordion sections and open accordion on product click
$(document).ready(function() {
    $('.product-link').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 1000);
        $(target).collapse('show');
    });
});

document.getElementById('proceedToPayment').addEventListener('click', function() {
    const deliveryType = document.querySelector('input[name="delivery"]:checked').value;
    const addressId = document.getElementById('addressId').value;
    const address1 = document.getElementById('address1').value;
    const address2 = document.getElementById('address2').value;
    const phone = document.getElementById('phone').value;
    const additionalInfo = document.getElementById('additionalInfo').value;
    const cartItems = document.getElementById('cartItemsInput').value;
    const productType = 'Food';

    // Client-side validation
    if (deliveryType === 'delivery' && (!addressId && !address1)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please provide a delivery address.',
        });
        return;
    }

    // Prepare data to send to the server
    const data = {
        delivery_type: deliveryType,
        address_id: addressId,
        address_1: address1,
        address_2: address2,
        phone: phone,
        additional_information: additionalInfo,
        cart_items: cartItems,
        product_type: productType,
    };

    // Send data to the server
    axios.post('/customer/placeOrder', data)
        .then(function(response) {

            const redirectUrl = response.data.redirectUrl;
            const status = response.data.status;
            const message = response.data.message;

            if (redirectUrl) {
                window.location.href = redirectUrl;
            }

            if (status == 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: message,
                });
            }
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'An error occurred while processing your request.',
            });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('bookingDateTime').addEventListener('change', function () {
        const selectedDateTime = document.getElementById('bookingDateTime').value;
        checkAvailability(selectedDateTime);
    });
});

function checkAvailability(selectedDateTime) {
    axios.post('/customer/checkAvailability', { dateTime: selectedDateTime, productType: 'Food' })
        .then(function (response) {
            const isAvailable = response.data.available;
            if (!isAvailable) {
                showAvailabilityAlert("Selected date and time is not available. Please choose another.");
                document.getElementById('bookingDateTime').value = ''; 
            }
        })
        .catch(function (error) {
            console.error('Error checking availability:', error);
        });
}

function showAvailabilityAlert(message) {
    const alertDiv = document.getElementById('availabilityAlert');
    const messageParagraph = document.getElementById('availabilityMessage');
    messageParagraph.textContent = message;
    alertDiv.classList.add('show');
}

const isAuthenticatedElement = document.getElementById('isAuthenticated');
const isAuthenticated = isAuthenticatedElement.getAttribute('data-authenticated');

const storeStatusElement = document.getElementById('storeStatus');
const storeStatus = storeStatusElement.getAttribute('data-status');


document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('page-header-notifications-dropdown');
    var cartSection = document.getElementById('cart-session');

    button.addEventListener('click', function() {
        cartSection.scrollIntoView({ behavior: 'smooth' });
    });
});

document.getElementById('proceedToCheckoutBtn').addEventListener('click', function() {
    const deliveryType = document.querySelector('input[name="delivery"]:checked').value;

    if (!isAuthenticated) {
        $('#loginModal').modal('show');
    } else {
        if (deliveryType === 'pickup') {
            // Show payment modal directly
            $('#paymentModal').modal('show');
        } else {
            $('#addressModal').modal('show');
        }
    }
});


document.getElementById('makePaymentBtn').addEventListener('click', function() {
    $('#addressModal').modal('hide');
    $('#paymentModal').modal('show');
});

if (!isAuthenticated){
    document.getElementById('auth').addEventListener('click', function() {
        $('#loginModal').modal('show');
    });
}

$(document).ready(function() {
    if (storeStatus == 'Closed') {
        $('#storeClosModal').modal('show');
    }
});

