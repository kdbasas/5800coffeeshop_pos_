@foreach($cartItems as $item)
    <li class="list-group-item d-flex justify-content-between align-items-center" id="cart-item-{{ $item->cart_id }}">
        <div>{{ $item->product->product_name }}</div>
        <div>
            <span id="quantity_{{ $item->cart_id }}">{{ $item->quantity }}</span>
        </div>
        <div id="cart-item-total-{{ $item->cart_id }}" class="cart-item-total-price">
            ${{ number_format($item->product->price * $item->quantity, 2) }}
        </div>
        <button onclick="removeFromCart('{{ $item->cart_id }}')" class="btn btn-danger btn-sm">Remove</button>
    </li>
@endforeach
