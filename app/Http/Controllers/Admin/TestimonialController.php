<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-read'])) {
            $query = Testimonial::orderBy('id', 'DESC');

            if ($request->id) {
                $query->where('id', $request->id);
            }

            if ($request->title) {
                $query->where('name', 'LIKE', '%' . $request->title . '%');
            }

            $testimonials = $query->paginate(10);

            return view('admin.testimonials.index', compact('testimonials', ));
        } else {
            return view('error.admin-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-create'])) {


            return view('admin.testimonials.create');
        } else {
            return view('error.admin-unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-create'])) {

            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'university' => 'required',
                'icon' => 'required|image|mimes:jpg,png,svg,jpeg',
                'is_active' => 'nullable',
            ]);

            $path = $request->file('icon')->store('testimonials', 'public');
            Testimonial::create([
                'name' => $request->name,
                'description' => $request->description,
                'university' => $request->university,
                'icon' => $path,
                'is_active' => $request->has('is_active') ? true : false,
            ]);
            // dd(WhyPoint::create([
            //     'title' => $request->title,
            //     'description' => $request->description,
            //     'icon' => $path,
            // ]));

            return redirect()->back()->with('success', 'Testimonial added successfully!');
        } else {
            return view('error.admin-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-read'])) {
            $testimonial = Testimonial::findOrFail($id);

            return view('admin.testimonials.show', compact('testimonial'));
        } else {
            return view('error.admin-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {
            $testimonial = Testimonial::findOrFail($id);

            return view('admin.testimonials.edit', compact('testimonial', ));
        } else {
            return view('error.admin-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {

            $testimonials = Testimonial::findOrFail($id);

            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'university' => 'required',
                'icon' => 'nullable|image|mimes:jpg,png,svg,jpeg',
                'is_active' => 'nullable',
            ]);

            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('testimonials', 'public');
                $testimonials->icon = $path;
            }

            $testimonials->name = $request->name;
            $testimonials->university = $request->university;
            $testimonials->description = $request->description;
            $testimonials->is_active = $request->has('is_active') ? true : false;
            
            $testimonials->save();

            return redirect()->route('admin.testimonials.index');
        } else {
            return view('error.admin-unauthorized');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-delete'])) {

            $point = Testimonial::findOrFail($id);
            $point->delete();

            Session::flash('success', 'The point has been deleted');

            return redirect()->route('admin.testimonials.index');

        } else {
            return view('error.admin-unauthorized');
        }
    }
}
