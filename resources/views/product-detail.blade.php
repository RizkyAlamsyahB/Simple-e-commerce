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
                <div class="mt-auto">
                    <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data" class="">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="id">
                        <input type="hidden" value="{{ $product->name }}" name="name">
                        <input type="hidden" value="{{ $product->price }}" name="price">
                        <input type="hidden" value="{{ $product->image }}" name="image">

                        <div class="mt-3" style="display: flex; align-items: center;">
                            <label for="quantity" style="margin-right: 10px;">Quantity:</label>
                            <button type="button" class="btn btn-light " style="background: rgb(213, 213, 213)"
                                onclick="decreaseValue()">-</button>
                            <input type="text" id="quantity" name="quantity"
                                style="width: 50px; text-align: center; border: none; margin: 0 5px;" value="1"
                                required>
                            <button type="button" class="btn btn-light" style="background: rgb(213, 213, 213)"
                                onclick="increaseValue()">+</button>
                        </div>

                        <div class="input-group mt-5">
                            <button class="btn btn-light"
                                style="margin-right: 20px; background: #FFFFFF;  border-radius: 0px; color: #EE4D2D; border-color: #EE4D2D; border: 1px solid #EE4D2D; ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-cart-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                    <path
                                        d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                </svg> Add To Cart
                            </button>

                            <button class="btn btn-dark " style="background:#EE4D2D; border:none; border-radius:0px;">Buy
                                Now</button>
                        </div>
                    </form>
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
