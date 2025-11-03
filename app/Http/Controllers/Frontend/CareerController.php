<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CareerController extends Controller
{
    public function index()
    {
        $jobs = Job::active()->orderBy('sort_order')->get();
        return view('frontend.careers.index', compact('jobs'));
    }

    public function show(string $slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();
        abort_unless($job->is_active, 404);
        return view('frontend.careers.show', compact('job'));
    }

    public function apply(Request $request, Job $job)
    {
        abort_unless($job->is_active, 404);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'portfolio_url' => 'nullable|url|max:255',
            'cover_letter' => 'nullable|string',
        ]);

        $data = $request->only(['name','email','phone','portfolio_url','cover_letter']);
        $data['job_id'] = $job->id;

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('applications', 'public');
        }

        JobApplication::create($data);

        return back()->with('success', 'Lamaran Anda telah terkirim.');
    }
}


