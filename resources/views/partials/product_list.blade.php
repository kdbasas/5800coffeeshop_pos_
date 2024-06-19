@foreach($products as $product)
<div class="col-md-4 mb-3">
    <div class="card h-100" style="padding: 10px; margin: 5px;">
        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 150px; object-fit: cover;">
        <div class="card-body d-flex flex-column p-2">
            <h5 class="card-title" style="font-size: 1.1rem;">{{ $product->product_name }}</h5>
            <p class="card-text" style="font-size: 0.9rem;">${{ $product->price }}</p>
            <p id="alert-stock-{{ $product->product_id }}" class="alert-stock mb-2" data-current-alert-stock="{{ $product->alert_stock }}" data-original-alert-stock="{{ $product->alert_stock }}">Alert Stock: {{ $product->alert_stock }}</p>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeProductQuantity('{{ $product->product_id }}', -1)">-</button>
                </div>
                <input type="text" class="form-control text-center" value="1" id="quantity-{{ $product->product_id }}" readonly>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeProductQuantity('{{ $product->product_id }}', 1)">+</button>
                </div>
            </div>
            <button class="btn btn-warning btn-block mt-auto btn-sm" onclick="addToCart('{{ $product->product_id }}')">Add to Cart</button>
        </div>
    </div>
</div>
@endforeach

<style>
    .alert-stock {
        color: #f00; /* Example: Alert stock color */
        font-size: 0.8rem; /* Example: Alert stock font size */
    }
</style>
