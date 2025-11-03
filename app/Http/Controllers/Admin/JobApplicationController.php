<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('job')->latest()->get();
        return view('admin.jobs.applications', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        $application->load('job');
        return view('admin.jobs.application-show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:received,reviewed,interviewed,rejected,offer',
        ]);
        $application->update(['status' => $request->status]);
        return back()->with('success', 'Status aplikasi diperbarui.');
    }

    public function downloadCv(JobApplication $application)
    {
        if (!$application->cv_path || !Storage::disk('public')->exists($application->cv_path)) {
            return back()->with('error', 'CV tidak ditemukan.');
        }
        return Storage::disk('public')->download($application->cv_path);
    }
}


