<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->get();
        return view('admin.team-members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->only(['name','role','bio','email','linkedin','twitter','is_active','sort_order']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team-members.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $team_member)
    {
        return view('admin.team-members.edit', ['member' => $team_member]);
    }

    public function update(Request $request, TeamMember $team_member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->only(['name','role','bio','email','linkedin','twitter','is_active','sort_order']);

        if ($request->hasFile('photo')) {
            if ($team_member->photo) {
                Storage::disk('public')->delete($team_member->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $team_member->update($data);

        return redirect()->route('admin.team-members.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $team_member)
    {
        if ($team_member->photo) {
            Storage::disk('public')->delete($team_member->photo);
        }

        $team_member->delete();

        return redirect()->route('admin.team-members.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}


