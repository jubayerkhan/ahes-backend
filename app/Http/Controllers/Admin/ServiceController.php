<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('id', 'DESC')->paginate(10);
        return view('admin.services.index', compact('services'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'icon' => 'required|image|mimes:jpg,png,svg,jpeg',
            'is_active' => 'nullable',
            'is_feature' => 'nullable',
        ]);

        $path = $request->file('icon')->store('services', 'public');

        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $path,
            'is_active' => $request->has('is_active'),
            'is_feature' => $request->has('is_feature'),
        ]);

        return redirect()->back()->with('success', 'Service added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {
            $service = Service::findOrFail($id);

            return view('admin.services.edit', compact('service'));
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
            $service = Service::findOrFail($id);

            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'icon' => 'nullable|mimes:jpg,png,jpeg,gif,webp,svg',
                'is_active' => 'nullable',
                'is_feature' => 'nullable',
            ]);

            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('services', 'public');
                $service->icon = $path;
            }

            $service->title = $request->title;
            $service->description = $request->description;
            $service->is_active = $request->has('is_active');
            $service->is_feature = $request->has('is_feature');
            $service->save();

            return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
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
            $service = Service::findOrFail($id);
            $service->delete();

            return redirect()->back()->with('success', 'Service deleted successfully!');
        } else {
            return view('error.admin-unauthorized');
        }
    }
}
