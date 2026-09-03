<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@easybuy.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Seller
        User::create([
            'name' => 'Test Seller',
            'email' => 'seller@easybuy.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'email_verified_at' => now(),
        ]);

        // Create Customer
        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@easybuy.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create Test Product
        Product::create([
            'product_name' => 'Test Product',
            'description' => 'This is a test product for testing the order flow',
            'price' => 99.99,
            'category' => 'Electronics',
            'stock_quantity' => 10,
            'seller_id' => 2,
        ]);

        echo "✅ Test users and product created successfully!\n";
        echo "Admin: admin@easybuy.com / password\n";
        echo "Seller: seller@easybuy.com / password\n";
        echo "Customer: customer@easybuy.com / password\n";
    }
}