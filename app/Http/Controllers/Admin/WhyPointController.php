<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\WhyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class WhyPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-read'])) {
            $query = WhyPoint::orderBy('id', 'DESC');

            if ($request->id) {
                $query->where('id', $request->id);
            }

            if ($request->title) {
                $query->where('title', 'LIKE', '%' . $request->title . '%');
            }

            $whypoints = $query->paginate(10);

            return view('admin.why-points.index', compact('whypoints', ));
        } else {
            return view('error.admin-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-create'])) {

            return view('admin.why-points.create');
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
                'title' => 'required',
                'description' => 'required',
                'icon' => 'required|image|mimes:jpg,png,svg,jpeg',
                'is_active' => 'nullable',
            ]);

            $path = $request->file('icon')->store('why_points', 'public');
            WhyPoint::create([
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $path,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            return redirect()->back()->with('success', 'Why Point added successfully!');
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
            $point = WhyPoint::findOrFail($id);

            return view('admin.why-points.show', compact('point'));
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
            $point = WhyPoint::findOrFail($id);

            return view('admin.why-points.edit', compact('point', ));
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
            // $messages = [
            //     'role_id.required' => 'The Role field is required.',
            //     'name.required' => 'The Name field is required.',
            //     'email.required' => 'The Email field is required.',
            // ];

            $point = WhyPoint::findOrFail($id);

            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'icon' => 'nullable|image|mimes:jpg,png,svg,jpeg',
                'is_active' => 'nullable',
            ]);

            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('why-points', 'public');
                $point->icon = $path;
            }

            $point->title = $request->title;
            $point->description = $request->description;
            $point->is_active = $request->has('is_active') ? true : false;
            
            $point->save();

            return redirect()->route('admin.why-points.index');
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

            $point = WhyPoint::findOrFail($id);
            $point->delete();

            Session::flash('success', 'The point has been deleted');

            return redirect()->route('admin.why-points.index');

        } else {
            return view('error.admin-unauthorized');
        }
    }
}
