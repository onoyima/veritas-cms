<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebsiteEvent;
use App\Models\WebsiteStudentGroup;
use App\Models\WebsiteResearchGroup;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function getStudentGroups()
    {
        $groups = WebsiteStudentGroup::where('is_active', true)->get();
        return response()->json(['data' => $groups]);
    }

    public function getEvents()
    {
        $events = WebsiteEvent::where('is_active', true)
            ->where('event_type', 'social') // Default for Campus Life
            ->orderBy('start_date_and_time', 'desc')
            ->get();
        return response()->json(['data' => $events]);
    }

    public function getResearchGroups()
    {
        $groups = WebsiteResearchGroup::where('is_active', true)->get();
        return response()->json(['data' => $groups]);
    }
}
