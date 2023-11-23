<?php

namespace Database\Seeders;

use App\Models\CustomerOrderStatus;
use Illuminate\Database\Seeder;
use DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderStatus = new CustomerOrderStatus();

        DB::table('customer_order_statuses')->delete();

        $orderStatus->insert([
            ['name' => 'Payment pending'],
            ['name' => 'Order pushed to producer'],
            ['name' => 'Order in progress'],
            ['name' => 'Order awaiting drop off'],
            ['name' => 'Order dropped off'],
            ['name' => 'Order reached warehouse'],
            ['name' => 'Order out for delivery'],
            ['name' => 'Order delivery successful'],
        ]);
    }
}
