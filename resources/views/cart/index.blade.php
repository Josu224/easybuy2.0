@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mt-4">
    <h2>🛒 Your Shopping Cart</h2>

    @if($cartItems->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-shopping-cart" style="font-size: 48px;"></i>
            <h4 class="mt-3">Your cart is empty</h4>
            <a href="{{ route('products.browse') }}" class="btn btn-primary mt-2">Continue Shopping</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->product_name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; margin-right: 10px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <span>{{ $item->product->product_name }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($item->product->price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" class="form-control" style="width: 70px; margin-right: 5px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($item->subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>${{ number_format($total, 2) }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('products.browse') }}" class="btn btn-secondary">← Continue Shopping</a>
            <div>
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Clear entire cart?')">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clear Cart</button>
                </form>
                <a href="{{ route('orders.checkout') }}" class="btn btn-primary">Proceed to Checkout →</a>
            </div>
        </div>
    @endif
</div>
@endsection