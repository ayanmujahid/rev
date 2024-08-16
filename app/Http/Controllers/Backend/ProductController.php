<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
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

class ProductController extends Controller {
    /**
     * Display a listing of products with DataTables.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = Product::with('category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_type', function ($data) {
                    if ($data->category) {
                        return $data->category->category_type;
                    } else {
                        return 'Category Not Available';
                    }
                })
                ->addColumn('type', function ($data) {
                    if ($data->type == null) {
                        return 'Not Available';
                    } else {
                        return $data->type;
                    }
                })
                ->addColumn('description', function ($data) {
                    $description = $data->description;
                    if ($description == null) {
                        return '<p>Not Available</p>';
                    } else {
                        $shortDescription = strlen($description) > 20 ? substr($description, 0, 20) . '...' : $description;
                        return '<p>' . $shortDescription . '</p>';
                    }
                })
                ->addColumn('image', function ($data) {
                    $url = asset($data->image);
                    return '<img src="' . $url . '" alt="image" width="50px" height="50px">';
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
                              <a href="' . route('product.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['category_type', 'type', 'description', 'image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.product.index');
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        $categories = ProductCategory::where('status', 'active')->get();
        return view('backend.layout.product.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'category_id'    => 'required',
            'type'           => 'nullable|string',
            'title'          => 'required|string',
            'sub_title'      => 'nullable|string|max:100',
            'image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'original_price' => 'required|numeric|gt:0',
            'discount_price' => 'required|numeric|lt:original_price|gte:0',
            'description'    => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $product                 = new Product();
            $product->category_id    = $request->category_id;
            $product->type           = $request->type;
            $product->title          = $request->title;
            $product->sub_title      = $request->sub_title;
            $product->original_price = $request->original_price;
            $product->discount_price = $request->discount_price;
            $product->description    = $request->description;

            $randomString   = (string) Str::uuid();
            $Image          = Helper::fileUpload($request->file('image'), 'product', $request->image . '_' . $randomString);
            $product->image = $Image;

            $product->save();
            return redirect()->route('product.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::where('status', 'active')->get();
        return view('backend.layout.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'category_id'    => 'required',
            'type'           => 'nullable|string',
            'title'          => 'nullable|string',
            'sub_title'      => 'nullable|string|max:100',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'original_price' => 'nullable|numeric|gt:0',
            'discount_price' => 'nullable|numeric|lt:original_price|gte:0',
            'description'    => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $product                 = Product::findOrFail($id);
            $product->category_id    = $request->category_id;
            $product->type           = $request->type;
            $product->title          = $request->title;
            $product->sub_title      = $request->sub_title;
            $product->original_price = $request->original_price;
            $product->discount_price = $request->discount_price;
            $product->description    = $request->description;

            if ($request->hasFile('image')) {
                if ($product->image && File::exists(public_path($product->image))) {
                    File::delete(public_path($product->image));
                }
                $randomString   = (string) Str::uuid();
                $Image          = Helper::fileUpload($request->file('image'), 'product', $request->image . '_' . $randomString);
                $product->image = $Image;
            }

            $product->save();
            return redirect()->route('product.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }

    /**
     * Update the status of the specified product.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = Product::findOrFail($id);

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
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $product = Product::findOrFail($id);

        if (isset($product->image) && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
