<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller {
    /**
     * Display a listing of the Product Category.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = ProductCategory::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_image', function ($data) {
                    $url = asset($data->category_image);
                    return '<img src="' . $url . '" alt="category_image" width="50px" height="50px">';
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
                              <a href="' . route('productcategory.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['category_image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.product_categories.index');
    }

    /**
     * Show the form for creating a new Product Category.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.product_categories.create');
    }

    /**
     * Store a newly created Product Category in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'category_type'  => 'required|string',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $productcategory                = new ProductCategory();
            $productcategory->category_type = $request->category_type;

            $randomString                    = (string) Str::uuid();
            $Image                           = Helper::fileUpload($request->file('category_image'), 'category_image', $request->category_image . '_' . $randomString);
            $productcategory->category_image = $Image;

            $productcategory->save();
            return redirect()->route('productcategory.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified Product Category.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $productcategory = ProductCategory::findOrFail($id);
        return view('backend.layout.product_categories.edit', compact('productcategory'));
    }

    /**
     * Update the specified Product Category in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'category_type'  => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $productcategory                = ProductCategory::findOrFail($id);
            $productcategory->category_type = $request->category_type;

            if ($request->hasFile('category_image')) {
                if ($productcategory->category_image && File::exists(public_path($productcategory->category_image))) {
                    File::delete(public_path($productcategory->category_image));
                }
                $randomString                    = (string) Str::uuid();
                $Image                           = Helper::fileUpload($request->file('category_image'), 'category_image', $request->category_image . '_' . $randomString);
                $productcategory->category_image = $Image;
            }

            $productcategory->save();
            return redirect()->route('productcategory.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }

    /**
     * Toggle the status of the specified Product Category.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = ProductCategory::findOrFail($id);

        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();
            return response()->json([
                'error'   => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

    /**
     * Remove the specified Product Category from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $productcategory = ProductCategory::findOrFail($id);

        if (isset($productcategory->category_image) && File::exists(public_path($productcategory->category_image))) {
            File::delete(public_path($productcategory->category_image));
        }

        $productcategory->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
