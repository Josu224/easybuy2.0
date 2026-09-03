@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Orders</a></li>
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
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y H:i') }}</p>
                    <p>
                        <strong>Status:</strong>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">Processing</span>
                        @elseif($order->status == 'shipped')
                            <span class="badge bg-primary">Shipped</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">Delivered</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($order->status == 'disputed')
                            <span class="badge bg-danger">Disputed</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Dispute Section -->
            @if($order->customer_dispute == 'not_received')
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">⚠️ Customer Dispute</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-danger"><strong>Customer has NOT received this order!</strong></p>
                        <p><strong>Reason:</strong> {{ $order->dispute_reason }}</p>
                        <p><strong>Filed:</strong> {{ $order->disputed_at ? $order->disputed_at->format('M d, Y H:i') : '' }}</p>
                    </div>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Update Order Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="disputed" {{ $order->status == 'disputed' ? 'selected' : '' }}>Disputed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>

            @if($order->customer_reviewed_at && !$order->admin_verified_at)
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Verify Transaction</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Customer has received the product and left a review.</p>
                        
                        @if($order->customer_rating)
                            <p><strong>Customer Rating:</strong> {{ $order->customer_rating }}/5 ⭐</p>
                        @endif
                        
                        @if($order->customer_review)
                            <p><strong>Customer Review:</strong> {{ $order->customer_review }}</p>
                        @endif
                        
                        <form action="{{ route('admin.verifyOrder', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-double"></i> Verify & Complete Order
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if($order->admin_verified_at)
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">✅ Verified</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                        <p class="mt-2 mb-0">This order has been verified and completed.</p>
                        <small class="text-muted">{{ $order->admin_verified_at->format('M d, Y H:i') }}</small>
                    </div>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>City:</strong> {{ $order->shipping_city }}</p>
                    <p><strong>State:</strong> {{ $order->shipping_state }}</p>
                    <p><strong>ZIP:</strong> {{ $order->shipping_zip }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    @if($order->notes)
                        <p><strong>Notes:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection