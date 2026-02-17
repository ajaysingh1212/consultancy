<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display a listing of the resource
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Skill::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $skills = $query->latest()->paginate(15);

        return view('admin.skills.index', compact('skills'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show the form for creating a new resource
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.skills.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store a newly created resource in storage
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Skill::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'category' => $request->category,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Display the specified resource
    |--------------------------------------------------------------------------
    */

    public function show(Skill $skill)
    {
        return view('admin.skills.show', compact('skill'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show the form for editing the specified resource
    |--------------------------------------------------------------------------
    */

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update the specified resource in storage
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id,
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $skill->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'category' => $request->category,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Remove the specified resource from storage
    |--------------------------------------------------------------------------
    */

    public function destroy(Skill $skill)
    {
        // Optional: prevent delete if used in jobs
        if ($skill->jobs()->count() > 0) {
            return back()->with('error',
                'Skill cannot be deleted because it is linked to jobs.');
        }

        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
}
