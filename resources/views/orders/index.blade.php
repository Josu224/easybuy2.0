@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mt-4">
    <h2>📋 My Orders</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-receipt" style="font-size: 48px;"></i>
            <h4 class="mt-3">You have no orders yet</h4>
            <a href="{{ route('products.browse') }}" class="btn btn-primary mt-2">Start Shopping</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                           <td>
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
    @elseif($order->status == 'cancelled')
        <span class="badge bg-danger">Cancelled</span>
    @else
        <span class="badge bg-secondary">{{ $order->status }}</span>
    @endif
</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection