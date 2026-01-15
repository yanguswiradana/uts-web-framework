<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Comic;
use App\Models\Chapter;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_comics' => Comic::count(),
            'total_chapters' => Chapter::count(),
            'total_users' => User::count(),
            'total_views' => '2.4M', // Dummy data
            'reports' => 3
        ];

        $recentUpdates = Chapter::with('comic')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUpdates'));
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}