@extends('layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-center">Your Cart</h2>

        @if (count($cartItems) > 0)
            <table class="table table-bordered mt-8">
                <thead>
                    <tr>
                        <th class="py-3 px-4 w-25 text-center">Select</th>
                        <th class="py-3 px-4 w-25 text-center">Product</th>
                        <th class="py-3 px-4 text-center">Quantity</th>
                        <th class="py-3 px-4 text-center">Price</th>
                        <th class="py-3 px-4 text-center">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td class="py-3 px-4 text-center">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}">
                            </td>
                            <td class="py-3 px-4">
                                <div class="media">
                                    <img src="{{ $item->attributes->image }}" class="mr-4" alt="{{ $item->name }}"
                                        style="width: 220px; height: 200px;">
                                    <div class="media-body">
                                        <h5 class="text-gray-800 font-medium"
                                            style="font-size: 20px; font-family: Arial, Helvetica, sans-serif">
                                            {{ $item->name }}</h5>
                                        <p class="text-gray-500">{{ $item->attributes->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <div class="d-flex justify-content-center">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            class="form-control" style="width: 75px; text-align: center;">
                                    </div>
                                    <button type="submit" class="btn btn-dark mt-3 ">Update</button>
                                </form>
                            </td>

                            <td class="py-3 px-4 text-center">
                                <span class="text-gray-800 font-medium">Rp.
                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-gray-800 font-medium">Rp.
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-8">
                <div class="text-lg font-weight-bold d-flex justify-content-end">Total:</div>
                <div id="totalPrice" class="text-lg font-weight-bold d-flex justify-content-end">{{ Cart::getTotal() }}
                </div>
            </div>


            <div class="mt-4" style="text-align: right;">
                <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                    @csrf
                    <button class="btn btn-light btn-xl">Clear Cart</button>
                </form>
                <a href="#" class="btn btn-dark "
                    style="display: inline; margin-left: 10px; padding: 13px 20px;  font-size: 20px; ">Checkout</a>

            </div>
        @else
            <p class="text-center mt-8 text-gray-500">Your cart is empty.</p>
        @endif
    </section>
    <script>
        function calculateTotalPrice() {
            const selectedCheckboxes = document.querySelectorAll("input[name='selected_items[]']:checked");
            let totalPrice = 0;

            selectedCheckboxes.forEach(function (checkbox) {
                const row = checkbox.parentElement.parentElement;
                const subtotal = row.querySelector("td:nth-child(5)").innerText; // Update indeks ke-5
                totalPrice += parseFloat(subtotal.replace('Rp. ', '').replace('.', '').replace(',', ''));
            });

            const formattedTotalPrice = "Rp. " + totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            document.querySelector("#totalPrice").textContent = formattedTotalPrice;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll("input[name='selected_items[]']");
            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    calculateTotalPrice();
                });
            });

            calculateTotalPrice(); // Hitung total awal ketika halaman dimuat
        });
    </script>

@endsection
