<!DOCTYPE html>
<html>
<head>
    <title>My Shopping Cart</title>
    <style>
        /* CSS for cart item list */
        #cart-item-list {
            display: flex;
            flex-direction: column;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }

        .cart-item-title {
            flex-grow: 1;
        }

        .cart-item-quantity {
            margin: 0 10px;
        }

        .cart-item-action {
            cursor: pointer;
            color: blue;
        }

        /* CSS for cart total */
        #cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            font-weight: bold;
        }

        /* CSS for clear cart button */
        #clear-cart-button {
            display: block;
            margin-top: 10px;
            cursor: pointer;
            color: red;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>My Shopping Cart</h1>
    <div id="cart-item-list">
        <!-- Cart items will be dynamically added here -->
    </div>
    <div id="cart-total">
        <span>Total: $<span id="cart-total-amount">0.00</span></span>
        <button id="clear-cart-button">Clear Cart</button>
    </div>

    <script>
        // Sample item data
        var items = [
            {
                id: 1,
                title: 'Item 1',
                image: 'item1.jpg',
                price: 9.99,
                stock: 5
            },
            {
                id: 2,
                title: 'Item 2',
                image: 'item2.jpg',
                price: 14.99,
                stock: 3
            },
            {
                id: 3,
                title: 'Item 3',
                image: 'item3.jpg',
                price: 19.99,
                stock: 7
            }
        ];

        // Cart items array to store added items
        var cartItems = [];

        // Function to update cart UI
        function updateCartUI() {
            var cartItemContainer = document.getElementById('cart-item-list');
            cartItemContainer.innerHTML = '';

            // Loop through cart items and add them to the cart item container
            for (var i = 0; i < cartItems.length; i++) {
                var cartItem = cartItems[i];
                var item = getItemDataById(cartItem.id);

                // Create cart item element
                var cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';

                // Create cart item image element
                var cartItemImage = document.createElement('img');
                cartItemImage.src = item.image;
                cartItemElement.appendChild(cartItemImage);

                // Create cart item title element
                var cartItemTitle = document.createElement('div');
                cartItemTitle.className = 'cart-item-title';
                cartItemTitle.textContent = item.title;
                cartItemElement.appendChild(cartItemTitle);

                // Create cart item quantity element
                var cartItemQuantity = document.createElement('div');
                cartItemQuantity.className = 'cart-item-quantity';
		cartItemQuantity.textContent ='Quantity: ' + cartItem.quantity;
		cartItemElement.appendChild(cartItemQuantity);
		            // Create cart item action element
            var cartItemAction = document.createElement('div');
            cartItemAction.className = 'cart-item-action';
            cartItemAction.textContent = 'Remove';
            cartItemAction.setAttribute('data-id', item.id);
            cartItemAction.addEventListener('click', function(event) {
                var itemId = event.target.getAttribute('data-id');
                removeCartItem(itemId);
            });
            cartItemElement.appendChild(cartItemAction);

            // Add cart item element to cart item container
            cartItemContainer.appendChild(cartItemElement);
        }

        // Update cart total
        var cartTotalAmount = document.getElementById('cart-total-amount');
        cartTotalAmount.textContent = calculateCartTotal().toFixed(2);
    }

    // Function to calculate cart total
    function calculateCartTotal() {
        var total = 0;
        for (var i = 0; i < cartItems.length; i++) {
            var cartItem = cartItems[i];
            var item = getItemDataById(cartItem.id);
            total += item.price * cartItem.quantity;
        }
        return total;
    }

    // Function to get item data by id
    function getItemDataById(itemId) {
        for (var i = 0; i < items.length; i++) {
            if (items[i].id == itemId) {
                return items[i];
            }
        }
        return null;
    }

    // Function to add item to cart
    function addItemToCart(itemId) {
        var cartItem = getCartItemById(itemId);
        if (cartItem) {
            cartItem.quantity++;
        } else {
            cartItems.push({
                id: itemId,
                quantity: 1
            });
        }
        updateCartUI();
    }

    // Function to remove item from cart
    function removeCartItem(itemId) {
        var cartItem = getCartItemById(itemId);
        if (cartItem) {
            if (cartItem.quantity > 1) {
                cartItem.quantity--;
            } else {
                cartItems = cartItems.filter(function(item) {
                    return item.id != itemId;
                });
            }
            updateCartUI();
        }
    }

    // Function to get cart item by id
    function getCartItemById(itemId) {
        for (var i = 0; i < cartItems.length; i++) {
            if (cartItems[i].id == itemId) {
                return cartItems[i];
            }
        }
        return null;
    }

    // Function to clear cart
    function clearCart() {
        cartItems = [];
        updateCartUI();
    }

    // Add event listener for clear cart button
    var clearCartButton = document.getElementById('clear-cart-button');
    clearCartButton.addEventListener('click', function() {
        clearCart();
    });

    // Initialize cart UI
    updateCartUI();
</script>
</body>
</html>
