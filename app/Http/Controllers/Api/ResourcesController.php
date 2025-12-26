<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebsiteFaq;
use App\Models\WebsiteEvent;
use App\Models\WebsiteStudentGroup;
use App\Models\WebsitePersonnel;
use App\Models\WebsiteResearchGroup;
use App\Models\WebsiteNews;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function getFaqs(Request $request)
    {
        $search = $request->query('search');
        $faqs = WebsiteFaq::where('is_active', true)
            ->when($search, function($q) use ($search) {
                $q->where('question', 'like', '%' . $search . '%');
            })
            ->orderBy('order')
            ->get();
        return response()->json(['data' => $faqs]);
    }

    public function getNews(Request $request)
    {
        $limit = $request->input('limit', 10);
        $news = WebsiteNews::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        return response()->json(['data' => $news]);
    }

    public function showNews($slug)
    {
        $news = WebsiteNews::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json(['data' => $news]);
    }

    public function getStudentGroups()
    {
        $groups = WebsiteStudentGroup::where('is_active', true)->get();
        return response()->json(['data' => $groups]);
    }

    public function getEvents(Request $request)
    {
        $all = $request->query('all', false);
        $eventType = $request->query('event_type');
        $query = WebsiteEvent::where('is_active', true);
        if (!$all) {
            if ($eventType) {
                $query->where('event_type', $eventType);
            } else {
                $query->where('event_type', 'social');
            }
        }
        $events = $query->orderBy('start_date_and_time', 'desc')->get();
        return response()->json(['data' => $events]);
    }

    public function getResearchGroups()
    {
        $groups = WebsiteResearchGroup::where('is_active', true)->get();
        return response()->json(['data' => $groups]);
    }

    public function getManagement()
    {
        $management = WebsitePersonnel::where('is_active', true)
            ->whereNotNull('position')
            ->get();
        return response()->json(['data' => $management]);
    }

    public function getPersonnel($slug)
    {
        $personnel = WebsitePersonnel::where('slug', $slug)
            ->where('is_active', true)
            ->with('publications')
            ->firstOrFail();
        return response()->json(['data' => $personnel]);
    }

    public function getPrograms(Request $request)
    {
        $category = $request->query('category');
        $programs = \App\Models\WebsiteProgram::where('is_active', true)
            ->when($category, function($q) use ($category) {
                $q->where('program_category', $category);
            })
            ->with('course')
            ->get();
        return response()->json(['data' => $programs]);
    }

    public function getProgram($slug)
    {
        $program = \App\Models\WebsiteProgram::where('slug', $slug)
            ->where('is_active', true)
            ->with(['course.personnel.publications'])
            ->firstOrFail();
        return response()->json(['data' => $program]);
    }
}
