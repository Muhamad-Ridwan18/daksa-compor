<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'testimonials' => Testimonial::count(),
            'contact_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'pending_orders' => Order::status('pending')->count(),
        ];

        $recentOrders = Order::with('product')->latest()->limit(5)->get();
        $recentMessages = ContactMessage::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentMessages'));
    }
}
