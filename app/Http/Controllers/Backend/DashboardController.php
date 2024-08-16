<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Campaign;
use App\Models\FAQ;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subscribe;
use App\Models\UpcomingProject;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller {
    /**
     * Display the backend dashboard.
     *
     * @return View
     */
    public function index() {
        $user            = User::get()->count();
        $productcategory = ProductCategory::get()->count();
        $product         = Product::get()->count();
        $announcement    = Announcement::get()->count();
        $question        = FAQ::get()->count();
        $upcomingproject = UpcomingProject::get()->count();
        $campaign        = Campaign::get()->count();
        $subscribe       = Subscribe::get()->count();

        $totalCountsData = [
            'Users'              => $user,
            'Product Categories' => $productcategory,
            'Products'           => $product,
            'Announcements'      => $announcement,
            'FAQs'               => $question,
            'Upcoming Projects'  => $upcomingproject,
            'Campaigns'          => $campaign,
            'Subscribers'        => $subscribe,
        ];

        return view('backend.layout.dashboard', compact(
            'user',
            'productcategory',
            'product',
            'announcement',
            'question',
            'upcomingproject',
            'campaign',
            'subscribe',
            'totalCountsData'
        ));
    }
}
