<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\View\View;

class CampaignController extends Controller {
    /**
     * Fetches all active campaigns, calculates time left and achieved percentage for each,
     * and generates the YouTube embed URL for the campaign video.
     *
     * @return View
     */
    public function index() {
        $campaings = Campaign::where('status', 'active')->get();

        foreach ($campaings as $campaign) {
            $now           = Carbon::now();
            $duration_date = Carbon::parse($campaign->duration_date);
            $diff          = $duration_date->diff($now);

            $campaign->days_left    = $diff->days;
            $campaign->hours_left   = $diff->h;
            $campaign->minutes_left = $diff->i;

            // Calculate achieved percentage
            $campaign->achieved_percentage = ($campaign->achive_goal / $campaign->target_goal) * 100;

            // Parse the URL and get the video ID
            $urlParts = parse_url($campaign->video_link);
            $videoId  = '';
            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $queryParts);
                $videoId = $queryParts['v'] ?? '';
            }

            // Create the embed URL
            $campaign->embedUrl = "https://www.youtube.com/embed/$videoId";
        }

        return view('frontend.layout.campaign', compact('campaings'));
    }
}
