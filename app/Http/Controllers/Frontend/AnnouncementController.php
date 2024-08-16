<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller {
    /**
     * Fetches all active announcements and returns the announcement view with this data.
     *
     * @return View
     */
    public function index() {
        $announcements = Announcement::where('status', 'active')->get();
        return view('frontend.layout.announcement', compact('announcements'));
    }

    /**
     * Fetches a specific active announcement by its ID. If the announcement exists,
     * it returns the single-announcement view with the announcement data.
     * If the announcement does not exist, it redirects to the announcement index view.
     *
     * @param $slug
     * @return View|RedirectResponse
     */
    public function show($slug) {
        $announcement = Announcement::where('slug', $slug)->first();
        return view('frontend.layout.single-announcement', compact('announcement'));
    }
}
