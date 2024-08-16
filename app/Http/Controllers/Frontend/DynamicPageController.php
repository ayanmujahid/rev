<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\View\View;

class DynamicPageController extends Controller {
    /**
     * index method handles the display of the dynamic page based on the page_slug
     *
     * @param string $page_slug
     * @return View
     */
    public function index(string $page_slug) {
        $pageData = DynamicPage::where('status', 'active')->where("page_slug", $page_slug)->first();
        return view('frontend.layout.dynamic_page', compact('pageData'));
    }
}
