<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\TrackingAffiliation;
use App\Http\Controllers\Controller;
use App\Models\AffiliateDistribution;
use App\Models\AffiliateLink;
use App\Models\Package;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::with(['carts.product'])
            ->where('user_id', $user->id)
            ->where('payment_status', 'successful')
            ->get();

        $data = Order::with(['carts.product'])
            ->where('user_id', $user->id)
            ->where('payment_status', 'pending')
            ->get();

        $getData = TrackingAffiliation::where('user_id', $user->id);

        // dd($getData->count());
        if ($getData->count() > 0) {
            $getTrackingAffiliated = TrackingAffiliation::where('affiliated_code', $getData->first()->affiliated_code)
            ->where('created_at', '>=', $getData->first()->created_at)->get();
        }else{
            $getTrackingAffiliated = [];
        }

        $links = AffiliateLink::where('user_id', auth()->user()->id)->get();

        $commissions = AffiliateDistribution::where('user_id', auth()->user()->id)->get();

        return view('frontend.layout.dashboard', compact('orders', 'data', 'getTrackingAffiliated', 'links', 'commissions'));
    }
    public function viewTree(AffiliateLink $affiliateLink){
        $user = $affiliateLink->user;
        $user->children = User::where('user_code' ,$affiliateLink->user_code)->get();
        $this->getChildrens($user);
        // dd($user);
        return view('frontend.layout.viewTree', compact('user', 'affiliateLink'));
    }
    public function getChildrens(User &$user){
        foreach($user->children as $children){
            $links = AffiliateLink::where('user_id', $children->id)->get();
            $children->children = [];
            foreach($links as $link){
                $children->children = [...$children->children, ...User::where('user_code' ,$link->user_code)->get()];
            }
            $this->getChildrens($children);
        }
    }
    
    public function remove_product(int $id) {
        $data = Order::where('id', $id)->delete();
        return back()->with('t-success', 'Product Remove Successfully');
    }
}
