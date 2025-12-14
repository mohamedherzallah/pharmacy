<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_medicines' =>Medicine::count(),
            'total_pharmacies' => Pharmacy::count(),
            'total_orders'     => Order::count(),
            'total_revenue'    => Order::where('status', 'completed')->sum('total_amount'),
        ];

        return view('dashboard', compact('stats'));
    }
}
