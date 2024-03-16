<script>
    document.addEventListener('DOMContentLoaded', function () {
     fetchCartItems();

     // Event delegation for minus buttons
     document.addEventListener('click', function(event) {
         if (event.target.classList.contains('cart-minus-button')) {
             const quantityInput = event.target.parentNode.querySelector('.cart-quantity-input');
             if (parseInt(quantityInput.value) > 1) {
                 quantityInput.value = parseInt(quantityInput.value) - 1;
                 updateCartQuantity(event.target, 'decrease');
             }
         }
     });

     // Event delegation for plus buttons
     document.addEventListener('click', function(event) {
         if (event.target.classList.contains('cart-plus-button')) {
             const quantityInput = event.target.parentNode.querySelector('.cart-quantity-input');
             quantityInput.value = parseInt(quantityInput.value) + 1;
             updateCartQuantity(event.target, 'increase');
         }
     });

     const minusButtons = document.querySelectorAll('.minus-button');
     minusButtons.forEach(function(minusButton) {
         minusButton.addEventListener('click', function() {
             const quantityInput = this.parentNode.querySelector('.quantity-input');
             if (parseInt(quantityInput.value) > 1) {
                 quantityInput.value = parseInt(quantityInput.value) - 1;
             }
         });
     });

     const plusButtons = document.querySelectorAll('.plus-button');
     plusButtons.forEach(function(plusButton) {
         plusButton.addEventListener('click', function() {
             const quantityInput = this.parentNode.querySelector('.quantity-input');
             quantityInput.value = parseInt(quantityInput.value) + 1;
         });
     });

     const addToCartButtons = document.querySelectorAll('.add-to-cart-button');
         addToCartButtons.forEach(function(button) {
             button.addEventListener('click', function () {
                 const featureId = this.parentElement.querySelector('.feature-id').value;
                 const productId = this.parentElement.querySelector('.product-id').value;
                 const quantity = this.parentElement.querySelector('.quantity-input').value;
                 console.log(featureId, productId, quantity);
             
                 // Send a POST request to the Laravel route
                 axios.post('/customer/addToCart', { product_id: productId, feature_id: featureId, quantity: quantity })
                     .then(function (response) {
                         if (response.data.status === 'error') {
                             // Show a SweetAlert for record not found
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Product could not be added to cart',
                                 text: 'Product not found',
                             });
                         } else {
                             updateCartSection(response.data.cart);
                         }
                     })
                     .catch(function (error) {
                         console.error(error);
                     });
             });
         });

     });

     function updateCartQuantity(button, action) {
         const productId = button.parentElement.querySelector('.cart-product-id').value;
         const featureId = button.parentElement.querySelector('.cart-feature-id').value;

         axios.post('/customer/updateQuantity', { productId: productId, featureId: featureId, action: action })
             .then(function(response) {
                 fetchCartItems();
             })
             .catch(function(error) {
                 console.error(error);
             });
     }

     function fetchCartItems() {
         axios.get('/customer/getCartItems')
             .then(function(response) {
                 const cart = response.data.cart;
                 updateCartSection(cart);
             })
             .catch(function(error) {
                 console.error(error);
             });
     }

    function updateCartSection(cartItems) {
        const cartContainer = document.getElementById('cart-items-container');
        const orderContainer = document.getElementById('order-items-container');
        const subtotalElement = document.getElementById('subtotal');
        const orderSubtotalElement = document.getElementById('orderSubtotal');
        const cartItemsBadge = document.getElementById('cart-items-badge');
        let subtotal = 0;

        // Clear existing cart items
        cartContainer.innerHTML = '';
        orderContainer.innerHTML = '';

        if (cartItems.length > 0) {
            cartItemsBadge.textContent = cartItems.length;
            cartItems.forEach(function(cartItem) {
                const itemElement = document.createElement('div');
                itemElement.classList.add('px-3', 'mb-3');
                itemElement.innerHTML = `
                    <div class="row row-cols-lg-auto g-3 d-flex justify-content-between align-items-center flex-column flex-lg-row">
                        <div class="col-12">
                            <span>${cartItem.name}</span>
                        </div>
                        <div class="col-auto">
                            <div class="input-group input-group-sm flex-nowrap">
                                <input type="hidden" class="cart-product-id" value="${cartItem.product_id}">
                                <input type="hidden" class="cart-feature-id" value="${cartItem.feature_id}">
                                <button type="button" class="btn btn-outline-secondary input-group-text cart-minus-button">
                                    <i class="mdi mdi-minus"></i>
                                </button>
                                <input class="form-control cart-quantity-input" type="number" value="${cartItem.quantity}" min="1" style="max-width: 60px;">
                                <button type="button" class="btn btn-outline-secondary input-group-text cart-plus-button">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary input-group-text">
                                    <strong><span class="text-danger">$${(cartItem.price)}</span></strong>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p><small>${cartItem.description}</small></p>
                    <hr>
                `;

                cartContainer.appendChild(itemElement.cloneNode(true));
                orderContainer.appendChild(itemElement);

                subtotal += parseFloat(cartItem.price);
            });

            document.getElementById('cartItemsInput').value = JSON.stringify(cartItems);

            // Reattach event listeners for plus and minus buttons
            attachEventListeners();
        } else {
            cartContainer.innerHTML = '<p>Your cart is empty.</p>';
            cartItemsBadge.textContent = '0';
        }

        subtotalElement.textContent = subtotal.toFixed(2);
        orderSubtotalElement.textContent = subtotal.toFixed(2);
    }


    function attachEventListeners() {
         // Add event listeners for minus buttons
         const minusButtons = document.querySelectorAll('.cart-minus-button');
         minusButtons.forEach(function(minusButton) {
             minusButton.addEventListener('click', function() {
                 const quantityInput = this.parentNode.querySelector('.cart-quantity-input');
                 if (parseInt(quantityInput.value) > 1) {
                     quantityInput.value = parseInt(quantityInput.value) - 1;
                     updateCartQuantity(this, 'decrease');
                 }

                 if (parseInt(quantityInput.value) == 1) {
                     quantityInput.value = parseInt(quantityInput.value) - 1;
                     updateCartQuantity(this, 'delete');
                 }
             });
         });

         // Add event listeners for plus buttons
         const plusButtons = document.querySelectorAll('.cart-plus-button');
         plusButtons.forEach(function(plusButton) {
             plusButton.addEventListener('click', function() {
                 const quantityInput = this.parentNode.querySelector('.cart-quantity-input');
                 quantityInput.value = parseInt(quantityInput.value) + 1;
                 updateCartQuantity(this, 'increase');
             });
         });
     }
 </script>