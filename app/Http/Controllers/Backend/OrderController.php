<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AffiliateDistribution;
use App\Models\AffiliateLink;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Order::with(['user', 'shippingAddress'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function ($data) {
                    return $data->order_id;
                })
                ->addColumn('name', function ($data) {
                    return $data->user ? $data->user->name : 'Guest';
                })
                ->addColumn('email', function ($data) {
                    return $data->user? $data->user->email : 'Guest';
                })
                ->addColumn('subtotal', function ($data) {
                    return '$' . number_format($data->subtotal, 2);
                })
                ->addColumn('shipping_address', function ($data) {
                    return $data->shippingAddress->address . ', ' . $data->shippingAddress->town_city;
                })
                ->addColumn('phone', function ($data) {
                    return $data->shippingAddress->phone;
                })
                ->addColumn('shipping_cost', function ($data) {
                    return '$' . number_format($data->shipping_cost, 2);
                })
                ->addColumn('total', function ($data) {
                    return '$' . number_format($data->total, 2);
                })
                ->addColumn('payment_status', function ($data) {
                    $style = 'background: green; color: white; border: 1px solid green; padding: 4px; border-radius:12px; text-transform: uppercase;';
                    if ($data->payment_status == 'Pending') {
                        $style = 'background:orange; color: white; border: 1px solid green; padding: 6px; border-radius:12px; text-transform: uppercase;';
                    } elseif ($data->payment_status == 'cancelled') {
                        $style = 'background:red; color: white; border: 1px solid green; padding: 6px; border-radius:12px; text-transform: uppercase;';
                    }
                    return '<span style="' . $style . '">' . $data->payment_status . '</span>';
                })
                ->addColumn('date', function ($data) {
                    return $data->created_at->format('m/d/Y');
                })
                ->addColumn('products', function ($data) {
                    return $data->carts->map(function ($cart) {
                        return '<div style="margin-bottom: 10px;">' . $cart->title . ' (Qty: ' . $cart->quantity . ')</div>';
                    })->implode('');
                })
                ->addColumn('commission_distributed', function ($data) {
                    return '$'.number_format(AffiliateDistribution::where('order_id', $data->id)->sum('amount'), 2);
                })
                ->rawColumns(['order_id', 'name', 'email', 'subtotal', 'shipping_address', 'phone', 'shipping_cost', 'total', 'payment_status', 'date', 'products'])
                ->make();
        }
        return view('backend.layout.order.index');
    }

    public function claim_request() {
        return view('backend.layout.claim_request.index');
    }

    public function affiliate_subscriber() {
        $users = User::where('user_code','no-code')->get();
        foreach($users as &$user){
            $user->children = [];
            $affiliateLinks = AffiliateLink::where('user_id', $user->id)->get();
            $user->links = $affiliateLinks;
            foreach($user->links as $link){
                $user->children = [...$user->children, ...User::where('user_code' ,$link->user_code)->get()];
            }
            $this->getChildrens($user);
        }
        $usersTree = $users;
        return view('backend.layout.affiliate_subscriber.index')->with(compact('usersTree'));
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
}
