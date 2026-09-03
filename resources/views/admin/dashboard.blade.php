@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-4">
    <h2>Admin Dashboard</h2>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-users" style="font-size: 32px;"></i>
                        <h5 class="card-title mt-2">Users</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.products') }}" class="text-decoration-none">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-box" style="font-size: 32px;"></i>
                        <h5 class="card-title mt-2">Products</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.orders') }}" class="text-decoration-none">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart" style="font-size: 32px;"></i>
                        <h5 class="card-title mt-2">Orders</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('products.create') }}" class="text-decoration-none">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-plus" style="font-size: 32px;"></i>
                        <h5 class="card-title mt-2">Add Product</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Total Users</h5>
                    <h2 class="text-primary">{{ $stats['total_users'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Total Products</h5>
                    <h2 class="text-success">{{ $stats['total_products'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Total Orders</h5>
                    <h2 class="text-info">{{ $stats['total_orders'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Revenue</h5>
                    <h2 class="text-warning">${{ number_format($stats['total_revenue'], 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Pending Orders</h5>
                    <h3 class="text-warning">{{ $stats['pending_orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Completed Orders</h5>
                    <h3 class="text-success">{{ $stats['completed_orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Low Stock Products</h5>
                    <h3 class="text-danger">{{ $stats['low_stock'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td><span class="badge bg-info">{{ $order->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Users</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection