<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:vacancies,slug',
            'department' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'salary_range' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'short_description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->only([
            'title','slug','department','location','employment_type','salary_range','deadline','short_description','meta_description','description','requirements','benefits','is_active','sort_order'
        ]);
        
        // Slug will be auto-generated in model boot if empty

        Job::create($data);
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dibuat.');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:vacancies,slug,' . $job->id . ',id',
            'department' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'salary_range' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'short_description' => 'nullable|string',
            'meta_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->only([
            'title','slug','department','location','employment_type','salary_range','deadline','short_description','meta_description','description','requirements','benefits','is_active','sort_order'
        ]);
        
        // Generate slug if not provided and name changed
        if (empty($data['slug']) && isset($data['title']) && $data['title'] !== $job->title) {
            // Slug will be auto-generated in model boot
        }

        $job->update($data);
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}


