@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 col-6">
                    <div class="card mb-4">
                        <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                            <img class="card-img-top" src="{{ $product->image }}" alt="Card image cap"
                                style="max-height: 150px;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Rp.{{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
