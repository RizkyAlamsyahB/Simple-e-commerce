@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="img-fluid" src="{{ $product->image }}" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p>Price: Rp.{{ number_format($product->price, 0, ',', '.') }}</p>
                <p>Stock: {{ $product->stock }}</p>
                <div class="mt-3">
                    <label for="quantity">Quantity:</label>
                    <div class="input-group">
                        <span class="input-group-btn"></span>
                        <button type="button" class="btn btn-secondary" onclick="decreaseValue()">-</button>
                        </span>
                        <input type="text" id="quantity" name="quantity" style="width: 50px; text-align:center; border: none;"
                            value="1">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-secondary" onclick="increaseValue()">+</button>
                        </span>
                    </div>
                </div>
                <br>
                <div>
                    <p>Pengiriman Ke</p>
                    <p>Ongkos Kirim</p>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-light">Add to Cart</a>
                        <a href="#" class="btn btn-dark mr-2">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function increaseValue() {
            var value = parseInt(document.getElementById('quantity').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('quantity').value = value;
        }

        function decreaseValue() {
            var value = parseInt(document.getElementById('quantity').value, 10);
            value = isNaN(value) ? 1 : value;
            value <= 1 ? value = 1 : value--;
            document.getElementById('quantity').value = value;
        }
    </script>
@endsection
