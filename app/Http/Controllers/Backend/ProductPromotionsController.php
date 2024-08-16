<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\ProductPromotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductPromotionsController extends Controller
{
    // Method to display the MainstreamEntertainment index page
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductPromotion::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    // Adding thumb_image column with image URL
                    $url = asset($data->image);
                    $status = '<img src="' . $url . '" alt="image" width="50px" height="50px">';
                    return $status;
                })
                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch" style="margin-left:40px;">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {

                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('product.promotion.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layout.product_promtion.index');
    }

    public function create()
    {
        return view('backend.layout.product_promtion.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'                 => 'required|string',
            'promotion_type'        => 'required|string',
            'image'                 => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description'     => 'required|string',
        ]);

        try {
            $ProductPromotion                           = new ProductPromotion();
            $ProductPromotion->title                    = $request->title;
            $ProductPromotion->promotion_type           = $request->promotion_type;
            $ProductPromotion->short_description        = $request->short_description;

            $randomString = Str::random(20);

            $Image = Helper::fileUpload($request->file('image'), 'product-promotion', $request->image . '_' . $randomString);

            $ProductPromotion->image = $Image;
            $ProductPromotion->save();

            return redirect()->route('product.promotion.index')->with("t-success", "Created Successfully");
        } catch (Exception $e) {
            return redirect()->route('product.promotion.index')->with("t-error", "Failed to create");
        }
    }

    public function edit($id)
    {
        $ProductPromotion = ProductPromotion::findOrFail($id);
        return view('backend.layout.product_promtion.edit', compact('ProductPromotion'));
    }
    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'title'                 => 'required|string',
            'promotion_type'        => 'required|string',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description'     => 'required|string',
        ]);
        try {


            $ProductPromotion = ProductPromotion::findOrFail($request->id);
            $ProductPromotion->title                    = $request->title;
            $ProductPromotion->promotion_type           = $request->promotion_type;
            $ProductPromotion->short_description        = $request->short_description;

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                if ($ProductPromotion->image && File::exists(public_path($ProductPromotion->image))) {
                    File::delete(public_path($ProductPromotion->image));
                }
                $randomString   = (string) Str::uuid();
                $Image          = Helper::fileUpload($request->file('image'), 'ProductPromotion', $request->image . '_' . $randomString);
                $ProductPromotion->image = $Image;
            }

            $ProductPromotion->save();

            return redirect()->route('product.promotion.index')->with('t-success', 'Updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('product.promotion.index')->with('t-error', 'Failed to update .');
        }
    }

    public function destroy($id)
    {

        $ProductPromotion = ProductPromotion::findOrFail($id);
        if (isset($ProductPromotion->image)) {
            unlink($ProductPromotion->image);
        }
        $ProductPromotion->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    public function status($id)
    {
        $data = ProductPromotion::where('id', $id)->first();

        if ($data->status == 'active') {
            // If the current status is active, change it to inactive
            $data->status = 'inactive';
            $data->save();

            // Return JSON response indicating success with message and updated data
            return response()->json([
                'error' => false,
                'message' => 'Unpublished Successfully.',
                'data' => $data,
            ]);
        } else {
            // If the current status is inactive, change it to active
            $data->status = 'active';
            $data->save();

            // Return JSON response indicating success with message and updated data
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data' => $data,
            ]);
        }
    }
}
