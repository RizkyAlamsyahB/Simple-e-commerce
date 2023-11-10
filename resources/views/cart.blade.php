@extends('layouts.app')

@section('content')
    <div class="card-box">
        <h2 class="text-3xl font-bold mx-auto px-4 py-8">Laravel | Shopping Cart</h2>
    </div>
    <section class="container mx-auto px-4 py-8 mt-5">
        @if (count($cartItems) > 0)
            <table class="table table-bordered mt-8">
                <thead>
                    <tr>
                        <th class="py-3 px-4 w-25 text-center">
                            <input type="checkbox" id="checkAllCheckbox" style="text-align:center;">
                        </th>
                        <th class="py-3 px-4 w-25 text-center">Product</th>
                        <th class="py-3 px-4 text-center">Quantity</th>
                        <th class="py-3 px-4 text-center">Price</th>
                        <th class="py-3 px-4 text-center">Subtotal</th>
                        <th class="py-3 px-4 text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td class="py-3 px-4"
                                style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                    style="margin: 0; text-align: center;">
                            </td>

                            <td class="py-3 px-4">
                                <div class="media" style="display: flex; align-items: center;">
                                    <img src="{{ $item->attributes->image }}" class="mr-4" alt="{{ $item->name }}"
                                        style="width: 80px; height: 70px; margin-right: 10px;">
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
                                    <button type="submit" class="btn btn-dark mt-3 "
                                        style="background: #FFFFFF;  border-radius: 0px; color: #EE4D2D; border-color: #EE4D2D; border: 1px solid #EE4D2D; ">Update</button>
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

                            <td class="py-3 px-4 text-center">
                                <form action="" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </td>



                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="fixed-bottom card-box"
                style="background: #fff; padding: 20px; box-shadow: 0px -2px 4px rgba(0, 0, 0, 0.1);">
                <div class="container mx-auto d-flex justify-content-between align-items-center">

                    <div>
                        <label for="selectAllProducts" style="margin-right: 10px;">Select All Products</label>
                        <input type="checkbox" id="selectAllProducts" style="margin-left: 30px;" />

                        <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                            @csrf
                            <button class="clear-cart" style="margin-left:180px;">Clear All Cart</button>
                        </form>
                    </div>
                    <span id="selectedProductCount">Total: 0 product(s) </span>
                    <div>
                        <span id="totalPrice" class="text-lg font-weight-bold" style="color:#EE4D2D; font-size:30px;">Rp.
                            {{ Cart::getTotal() }}</span>

                        <a href="#" class="btn btn-dark" id="checkout-button" style="">Checkout</a>
                    </div>
                </div>
            </div>
        @else
            <p class="text-center mt-8 text-gray-500">Your cart is empty.</p>
        @endif
    </section>
    <script>
        function calculateTotalPrice() {
            const selectedCheckboxes = document.querySelectorAll("input[name='selected_items[]']:checked");
            let totalPrice = 0;

            selectedCheckboxes.forEach(function(checkbox) {
                const row = checkbox.parentElement.parentElement;
                const subtotal = row.querySelector("td:nth-child(5)").innerText;
                totalPrice += parseFloat(subtotal.replace('Rp. ', '').replace('.', '').replace(',', ''));
            });

            const formattedTotalPrice = "Rp. " + totalPrice.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            document.querySelector("#totalPrice").textContent = formattedTotalPrice;

            // Update the "Total: ... product" text
            updateSelectedProductCount(selectedCheckboxes.length);

            // Check or uncheck the "Select All Products" checkbox based on the number of selected items
            const selectAllCheckbox = document.querySelector("#selectAllProducts");
            const itemCheckboxes = document.querySelectorAll("input[name='selected_items[]']");
            selectAllCheckbox.checked = selectedCheckboxes.length === itemCheckboxes.length;
        }

        // Function to toggle all checkboxes
        function toggleCheckAll() {
            const checkAllCheckbox = document.querySelector("#checkAllCheckbox");
            const itemCheckboxes = document.querySelectorAll("input[name='selected_items[]']");

            itemCheckboxes.forEach(function(checkbox) {
                checkbox.checked = checkAllCheckbox.checked;
            });

            calculateTotalPrice();
        }

        // Function to handle the "Select All Products" checkbox
        function toggleSelectAllProducts() {
            const selectAllCheckbox = document.querySelector("#selectAllProducts");
            const itemCheckboxes = document.querySelectorAll("input[name='selected_items[]']");

            itemCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });

            calculateTotalPrice();
            updateSelectedProductCount(selectAllCheckbox.checked ? itemCheckboxes.length : 0);
        }

        // Function to update the selected product count
        function updateSelectedProductCount(count) {
            document.querySelector("#selectedProductCount").textContent =
                `Total: ${count} product${count !== 1 ? 's' : ''}`;
        }

        document.querySelector("#checkAllCheckbox").addEventListener("change", toggleCheckAll);
        document.querySelector("#selectAllProducts").addEventListener("change", toggleSelectAllProducts);

        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll("input[name='selected_items[]']");
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    calculateTotalPrice();
                });
            });

            calculateTotalPrice();
        });
    </script>



@endsection
