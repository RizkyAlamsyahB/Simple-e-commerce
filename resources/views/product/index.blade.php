@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Manage Products</h2>
                <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">Add New Product</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Description </th>
                            <th scope="col">Image</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>

                                <td>{{ $product->name }}</td>
                                <td>{{ Str::limit($product->description, 10) }}</td>
                                <td><img src="{{ $product->image }}" alt="{{ $product->name }}" width="50px"
                                    height="50px" style="object-fit: cover; object-position: center"></td>
                                <td>Rp.{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
