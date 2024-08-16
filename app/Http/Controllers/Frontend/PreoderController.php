<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\HappyUser;
use App\Models\LatestVideo;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PageSample;
use App\Models\PreOrderProduct;
use App\Models\PreOrderSpecial;
use App\Models\Product;
use App\Models\SalesGoal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
/**
 * Class PreoderController
 *
 * This controller handles the retrieval of active pre-order products, specials, page samples, latest videos, happy users, and merchandise products.
 * It then passes this data to the 'frontend.layout.preoder' view.
 *
 * @package App\Http\Controllers\Frontend
 */
class PreoderController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|Application
     */
    public function index(): Factory | View | Application {
        $preOrderProduct = PreOrderProduct::where('status', 'active')->first();
        $preOrderSpecial = PreOrderSpecial::where('status', 'active')->first();
        $pageSamples     = PageSample::where('status', 'active')->get();
        $latestVideos    = LatestVideo::where('status', 'active')->get();
        $happyusers      = HappyUser::where('status', 'active')->get();
        $products        = Product::where('status', 'active')->where('type', 'Merchandise')->get();
        $salesGoals       = SalesGoal::where('status', 'active')->orderBy('sales_target')->get(); // Order by sales_target
        $videos = LatestVideo::all();
        $orders = Cart::where('product_id', 11)->get();
        $totalSum = $orders->sum('total');
        $orderCount = $orders->count();
        $totalGoal = 50;
        $product   = Product::where('status', 'active')->where('type', 'pre-order')->first();
        $data = [
            'preOrderProduct' => $preOrderProduct,
            'preOrderSpecial' => $preOrderSpecial,
            'pageSamples'     => $pageSamples,
            'latestVideos'    => $latestVideos,
            'happyusers'      => $happyusers,
            'products'        => $products,
            'salesGoals'       => $salesGoals,
        ];
        return view('frontend.layout.preoder', compact('data', 'product','videos','orders', 'totalSum', 'orderCount', 'totalGoal'));
    }
    
}