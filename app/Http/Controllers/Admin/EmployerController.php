<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $employers = Employer::latest()->paginate(10);
        return view('admin.employers.index', compact('employers'));
    }

    public function create()
    {
        return view('admin.employers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required|email',
        ]);

        Employer::create($request->all());

        return redirect()->route('admin.employers.index')
            ->with('success','Employer created successfully');
    }

    public function show(Employer $employer)
    {
        return view('admin.employers.show', compact('employer'));
    }

    public function edit(Employer $employer)
    {
        return view('admin.employers.edit', compact('employer'));
    }

    public function update(Request $request, Employer $employer)
    {
        $employer->update($request->all());

        return redirect()->route('admin.employers.index')
            ->with('success','Employer updated successfully');
    }

    public function destroy(Employer $employer)
    {
        $employer->delete();
        return back()->with('success','Employer deleted');
    }

}
