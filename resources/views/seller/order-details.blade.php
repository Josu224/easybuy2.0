@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('seller.orders') }}">My Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    @if($item->product->seller_id == auth()->id() || auth()->user()->isAdmin())
                                        <tr>
                                            <td>{{ $item->product->product_name }}</td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>City:</strong> {{ $order->shipping_city }}</p>
                    <p><strong>State:</strong> {{ $order->shipping_state }}</p>
                </div>
            </div>

            @if($order->seller_agreement == null)
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Action Required</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('seller.orders.accept', $order->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Accept Order</button>
                        </form>
                        
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            Reject Order
                        </button>
                    </div>
                </div>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject Order</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('seller.orders.reject', $order->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="form-label">Reason for rejection:</label>
                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Reject Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if($order->seller_agreement == 'accepted' && !$order->product_sent_at)
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Shipping</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('seller.orders.sent', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Mark as Sent</button>
                        </form>
                    </div>
                </div>
            @endif

            @if($order->customer_review)
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Customer Review</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Rating:</strong> {{ $order->customer_rating }}/5 ⭐</p>
                        <p><strong>Review:</strong> {{ $order->customer_review }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection