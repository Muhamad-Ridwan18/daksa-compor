<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->with('products')->orderBy('sort_order')->get();
        $testimonials = Testimonial::active()->orderBy('sort_order')->get();
        $clients = Client::active()->orderBy('sort_order')->get();
        $teamMembers = TeamMember::active()->orderBy('sort_order')->get();
        $settings = Setting::getAllAsArray();

        return view('frontend.home', compact('services', 'testimonials', 'clients', 'teamMembers', 'settings'));
    }
}
