@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mt-4">
    <h2>📦 Checkout</h2>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.place') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="shipping_city" class="form-label">City:</label>
                                <input type="text" class="form-control" id="shipping_city" name="shipping_city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="shipping_state" class="form-label">State:</label>
                                <input type="text" class="form-control" id="shipping_state" name="shipping_state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="shipping_zip" class="form-label">ZIP Code:</label>
                                <input type="text" class="form-control" id="shipping_zip" name="shipping_zip" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (optional):</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item->product->product_name }} x {{ $item->quantity }}</span>
                            <span>${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection