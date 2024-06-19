@extends('layout.main')

@section('content')
<style>
    body {
        background-color: #F4CD81;
    }
</style>
<div class="container-fluid mt-4 p-0" style="min-height: 100vh;">
    <div class="text-center mb-4">
        <img src="{{ asset('img/5800 logo.png') }}" alt="Coffee Shop Logo" style="max-width: 200px;">
        <h1 class="mb-0">Coffee Shop POS</h1>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('employee.dashboard') }}" class="btn btn-primary" style="background-color: green;">Back to Dashboard</a>
    </div>
    <div class="row">
        <!-- Type Buttons Section -->
        <div class="col-md-12 mb-3 text-center">
            @foreach($types as $type)
                <button class="btn btn-primary mx-1 my-1 filter-btn" onclick="filterProducts({{ $type->type_id }})">{{ $type->type_name }}</button>
            @endforeach
            <button class="btn btn-secondary my-1" onclick="resetFilter()">Reset</button>
        </div>

        <!-- Products Section -->
        <div class="col-md-8" id="products">
            <div class="row">
                @include('partials.product_list', ['products' => $products])
            </div>
        </div>

        <!-- Cart Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">CART</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group" id="cart-items">
                        @include('partials.cart_item', ['cartItems' => $cartItems])
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total:</strong>
                        <div id="total">${{ $total }}</div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <form id="clearCartForm" method="post" action="{{ route('employee.sell.clearCart') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">Clear Cart</button>
                    </form>
                    <form id="checkoutForm" method="post" action="{{ route('employee.sell.checkout') }}">
                        @csrf
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $customerName }}" required>
                        </div>
                        <div class="form-group">
                            <label for="paid_amount">Amount Paid</label>
                            <input type="number" class="form-control" id="paid_amount" name="paid_amount" min="0" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method }}">{{ ucfirst($method) }}</option>
                                @endforeach
                            </select>
                        </div>                                         
                        <button type="submit" class="btn btn-success btn-block">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function addToCart(productId) {
        let quantity = parseInt($('#quantity-' + productId).val());
        $.ajax({
            type: 'POST',
            url: '{{ route("employee.sell.addToCart") }}',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity,
                customer_name: $('#customer_name').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-items').html(response.cartHtml);
                    updateTotal(response.new_total);
                    updateAlertStock(productId, response.product_alert_stock);
                } else {
                    console.error('Failed to add product to cart.');
                    alert('Failed to add product to cart. ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to add product to cart. Please try again.');
            }
        });
    }
    function updateQuantity(cartId, newQuantity) {
    fetch(`/employee/sell/update-quantity/${cartId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Update UI with new quantity and total
        document.getElementById(`quantity_${cartId}`).textContent = data.cartItem.quantity;
        document.getElementById(`cart-item-total-${cartId}`).textContent = `$${data.cartItem.product.price * data.cartItem.quantity}`;
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
        // Handle error - show a message, revert UI changes, etc.
    });
}


function removeFromCart(cartItemId) {
    $.ajax({
        type: 'DELETE',
        url: `/employee/sell/remove-from-cart/${cartItemId}`,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#cart-item-' + cartItemId).remove(); // Remove the cart item from UI
            updateTotal(response.new_total); // Update the total in UI

            // Update alert stock for the removed item
            updateAlertStock(response.product_id, response.product_alert_stock);
        },
        error: function(xhr) {
            console.error('Failed to remove from cart:', xhr.responseText);
            alert('Failed to remove from cart. Please try again.');
        }
    });
}

    function clearCart() {
        $.ajax({
            type: 'POST',
            url: '{{ route("employee.sell.clearCart") }}',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                $('.alert-stock').each(function() {
                    let productId = $(this).data('product-id');
                    let originalAlertStock = $(this).data('original-alert-stock');
                    $(this).text('Alert Stock: ' + originalAlertStock);
                    $(this).data('current-alert-stock', originalAlertStock);
                });

                $('#cart-items').empty();
                updateTotal(0);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to clear cart. Please try again.');
            }
        });
    }

    function changeQuantity(cartId, currentQuantity, amount) {
    let newQuantity = currentQuantity + amount;

    // Ensure minimum quantity is 1
    if (newQuantity < 1) {
        newQuantity = 1;
    }

    $.ajax({
        type: 'PATCH',
        url: `/employee/sell/update-quantity/${cartId}`,
        data: {
            _token: '{{ csrf_token() }}',
            quantity: newQuantity
        },
        success: function(response) {
            if (response.cartItem) {
                // Update UI with new quantity and total in cart
                $('#quantity_' + cartId).text(response.cartItem.quantity);
                $('#cart-item-total-' + cartId).text('$' + (response.cartItem.product.price * response.cartItem.quantity).toFixed(2));
                updateTotal(response.new_total);
                updateButtonState(cartId, response.cartItem.quantity);

                // Update alert stock in product list
                updateProductListAlertStock(response.cartItem.product.id, response.product_alert_stock);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Failed to update quantity. Please try again.');
        }
    });
}

function updateProductListAlertStock(productId, newAlertStock) {
    $('#alert-stock-' + productId).text('Alert Stock: ' + newAlertStock);
}

    function updateTotal(newTotal) {
        $('#total').text('$' + newTotal.toFixed(2));
    }

    function updateAlertStock(productId, newAlertStock) {
        $('#alert-stock-' + productId).text('Alert Stock: ' + newAlertStock);
    }

    function updateButtonState(cartId, quantity) {
        const decreaseButton = $('#cart-item-' + cartId).find('.btn-decrease');

        // Disable decrease button if quantity is 1 or less
        if (quantity <= 1) {
            decreaseButton.prop('disabled', true);
        } else {
            decreaseButton.prop('disabled', false);
        }
    }


function changeProductQuantity(productId, amount) {
    const quantityElement = document.getElementById(`quantity-${productId}`);
    let currentQuantity = parseInt(quantityElement.value);
    currentQuantity += amount;
    if (currentQuantity < 1) {
        currentQuantity = 1;
    }
    quantityElement.value = currentQuantity;

    // Update alert stock display
    updateAlertStock(productId, $('#alert-stock-' + productId).data('original-alert-stock') - currentQuantity);
}

function filterProducts(typeId) {
        $('.filter-btn').removeClass('active');
        $('.filter-btn[data-type-id="' + typeId + '"]').addClass('active');
        $.ajax({
            type: 'GET',
            url: '{{ route("employee.sell.filterProducts") }}',
            data: { type_id: typeId },
            success: function(response) {
                $('#products .row').html(response.productsHtml);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to filter products. Please try again.');
            }
        });
    }

    function resetFilter() {
        $('.filter-btn').removeClass('active');
        $.ajax({
            type: 'GET',
            url: '{{ route("employee.sell.index") }}',
            success: function(response) {
                $('#products .row').html($(response).find('#products .row').html());
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Failed to reset filters. Please try again.');
            }
        });
    }
</script>
@endsection
