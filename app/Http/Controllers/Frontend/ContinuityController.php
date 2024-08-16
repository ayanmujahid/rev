<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductPromotion;
use App\Models\LatestVideo;
use App\Models\UpcomingProject;
use Illuminate\View\View;

class ContinuityController extends Controller {
    /**
     * The index method is the default method for this controller.
     * It fetches all active upcoming projects and the first active product promotion of type 'limited_offer'.
     * It also formats the release date of each project to 'F, Y' format.
     * Finally, it returns the 'continuity' view with the fetched data.
     *
     * @return View
     */
    public function index() {
        $videos = LatestVideo::all();
        $upcomingProjects = UpcomingProject::where('status', 'active')->get();

        foreach ($upcomingProjects as $project) {
            $project->releas_date = date('F, Y', strtotime($project->releas_date));
        }

        $ProductPromotions = ProductPromotion::where('status', 'active')->where('promotion_type', 'limited_offer')->first();
        return view('frontend.layout.continuity', compact('upcomingProjects', 'ProductPromotions', 'videos'));
    }
}
