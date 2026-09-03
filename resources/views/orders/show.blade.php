@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <!-- Order Timeline -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📅 Order Timeline</h5>
        </div>
        <div class="card-body">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon bg-success">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="mb-0">Order Placed</h6>
                        <small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small>
                    </div>
                </div>
                
                @if($order->seller_agreement == 'accepted')
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Seller Accepted</h6>
                            <small class="text-muted">{{ $order->seller_accepted_at ? $order->seller_accepted_at->format('M d, Y H:i') : '' }}</small>
                        </div>
                    </div>
                @elseif($order->seller_agreement == 'rejected')
                    <div class="timeline-item">
                        <div class="timeline-icon bg-danger">
                            <i class="fas fa-times text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Order Rejected</h6>
                            <small class="text-muted">{{ $order->seller_rejection_reason }}</small>
                        </div>
                    </div>
                @else
                    <div class="timeline-item">
                        <div class="timeline-icon bg-warning">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Waiting for Seller</h6>
                            <small class="text-muted">Seller has not responded yet</small>
                        </div>
                    </div>
                @endif
                
                @if($order->product_sent_at)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-shipping-fast text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Product Shipped</h6>
                            <small class="text-muted">{{ $order->product_sent_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                @endif
                
                @if($order->customer_received_at)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-box-open text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Product Received</h6>
                            <small class="text-muted">{{ $order->customer_received_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                @endif
                
                @if($order->customer_dispute == 'not_received')
                    <div class="timeline-item">
                        <div class="timeline-icon bg-danger">
                            <i class="fas fa-exclamation text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Dispute Filed: Not Received</h6>
                            <small class="text-muted">{{ $order->disputed_at ? $order->disputed_at->format('M d, Y H:i') : '' }}</small>
                        </div>
                    </div>
                @endif
                
                @if($order->customer_reviewed_at)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Review Submitted</h6>
                            <small class="text-muted">{{ $order->customer_reviewed_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                @endif
                
                @if($order->admin_verified_at)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-check-double text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Order Completed</h6>
                            <small class="text-muted">{{ $order->admin_verified_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

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

            <div class="card shadow mb-4">
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

            <!-- Customer Actions -->
            @if($order->product_sent_at && !$order->customer_received_at && !$order->customer_dispute)
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Confirm Delivery</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.received', $order->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check"></i> I have received this order
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#notReceivedModal">
                            <i class="fas fa-times"></i> I have NOT received this order
                        </button>
                    </div>
                </div>

                <!-- Not Received Modal -->
                <div class="modal fade" id="notReceivedModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Report Issue</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('orders.notReceived', $order->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p class="text-muted">Please explain why you have not received this order:</p>
                                    <div class="mb-3">
                                        <label for="dispute_reason" class="form-label">Reason:</label>
                                        <textarea class="form-control" id="dispute_reason" name="dispute_reason" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Submit Dispute</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if($order->customer_dispute == 'not_received')
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">⚠️ Dispute Filed</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-danger"><strong>You reported that you have not received this order.</strong></p>
                        <p><strong>Reason:</strong> {{ $order->dispute_reason }}</p>
                        <p class="text-muted">Admin will review this dispute.</p>
                    </div>
                </div>
            @endif

            @if($order->customer_received_at && !$order->customer_reviewed_at)
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Leave a Review</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.review', $order->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating:</label>
                                <select class="form-control" id="rating" name="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                                    <option value="3">⭐⭐⭐ (3 Stars)</option>
                                    <option value="2">⭐⭐ (2 Stars)</option>
                                    <option value="1">⭐ (1 Star)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="review" class="form-label">Your Review:</label>
                                <textarea class="form-control" id="review" name="review" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection