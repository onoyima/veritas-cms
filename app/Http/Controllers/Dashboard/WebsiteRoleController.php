<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\WebsiteRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteRoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $staffResults = [];
        
        // Retain server-side search for fallback/non-JS users or deep linking
        if ($search) {
            $staffResults = Staff::where(function($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->limit(20)->get();
        }

        $roles = WebsiteRole::all();

        // Get all staff with roles (Current Assignments)
        $assignedStaff = Staff::has('websiteRoles')
            ->with('websiteRoles')
            ->latest('updated_at')
            ->paginate(10);

        return view('dashboard.admin.website-roles.index', compact('roles', 'staffResults', 'assignedStaff', 'search'));
    }

    public function searchStaff(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $staff = Staff::where(function($q) use ($query) {
            $q->where('fname', 'like', "%{$query}%")
              ->orWhere('lname', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%");
        })
        ->limit(10)
        ->get(['id', 'fname', 'lname', 'email']);

        return response()->json($staff);
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'role_id' => 'required|exists:website_roles,id',
        ]);

        $staff = Staff::findOrFail($request->staff_id);
        
        // Check if already has role
        if (!$staff->websiteRoles()->where('id', $request->role_id)->exists()) {
            $staff->websiteRoles()->attach($request->role_id);
            return redirect()->route('admin.website-roles.index')->with('success', 'Role assigned successfully.');
        }

        return redirect()->route('admin.website-roles.index')->with('warning', 'Staff member already has this role.');
    }

    public function destroy(Request $request, Staff $staff, WebsiteRole $role)
    {
        $staff->websiteRoles()->detach($role->id);
        return redirect()->route('admin.website-roles.index')->with('success', 'Role removed successfully.');
    }
}
