<?php

namespace App\Http\Controllers;
use App\Models\Service;

use App\Models\Testimonial;
use App\Models\whyPoint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $whypoints = whyPoint::where('is_active', true)->get();
        $services = Service::where('is_active', true)->where('is_feature', true)->orderBy('id', 'DESC')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('id', 'DESC')->get();
        
        return view('home.index', compact('whypoints', 'services', 'testimonials'));
    }
    public function contact()
    {
        return view('home.contact');
    }
    public function know()
    {
        $teamMembers = [
            ['name' => 'Joel Hauer', 'role' => 'Co-founder', 'photo' => 'images/emp-photo-1.png'],
            ['name' => 'Emily Clark', 'role' => 'CEO', 'photo' => 'images/emp-photo-2.png'],
            ['name' => 'Michael Lee', 'role' => 'Manager', 'photo' => 'images/emp-photo-3.png'],
            ['name' => 'Sarah Brown', 'role' => 'Designer', 'photo' => 'images/emp-photo-4.png'],
        ];

        return view('home.know', compact('teamMembers'));
    }
    public function service()
    {
        $services = Service::where('is_active', true)->get();
        
        return view('home.service', compact('services'));
    }

    // public function login()
    // {
    //     return view('home.login');
    // }
    // public function logout(Request $request)
    // {
    //     Auth::logout(); // 💥 Logs out the current user
    //     $request->session()->invalidate(); // ❌ Clears session data
    //     $request->session()->regenerateToken(); // 🔒 Creates a new CSRF token

    //     return redirect()->route('login'); // 🔁 Redirect back to login page
    // }


}
