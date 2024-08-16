<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\PreOrderProduct;
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

class PreOrderProductController extends Controller {
    /**
     * Display a listing of the Pre Order Product.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = PreOrderProduct::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description      = $data->description;
                    $shortDescription = strlen($description) > 20 ? substr($description, 0, 20) . '...' : $description;
                    return '<p>' . $shortDescription . '</p>';
                })
                ->addColumn('recommended_age', function ($data) {
                    return '<div style="text-align:center;">' . $data->recommended_age . '+' . '</div>';
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
                              <a href="' . route('pre_order_product.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['description', 'recommended_age', 'image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.pre_order_product.index');
    }

    /**
     * Show the form for creating a new Pre Order Product.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.pre_order_product.create');
    }

    /**
     * Store a newly created Pre Order Product in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */

    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'title'           => 'required',
            'image'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'recommended_age' => 'required|numeric|gte:7|lte:120',
            'genre'           => 'required',
            'description'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pre_order_product                  = new PreOrderProduct();
            $pre_order_product->title           = $request->title;
            $pre_order_product->recommended_age = $request->recommended_age;
            $pre_order_product->genre           = $request->genre;
            $pre_order_product->description     = $request->description;

            $randomString             = (string) Str::uuid();
            $Image                    = Helper::fileUpload($request->file('image'), 'pre_order_product', $request->image . '_' . $randomString);
            $pre_order_product->image = $Image;

            $pre_order_product->save();
            return redirect()->route('pre_order_product.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified Pre Order Product.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $pre_order_product = PreOrderProduct::findOrFail($id);
        return view('backend.layout.pre_order_product.edit', compact('pre_order_product'));
    }

    /**
     * Update the specified Pre Order Product in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'title'           => 'nullable',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'recommended_age' => 'nullable|numeric|gte:7|lte:120',
            'genre'           => 'nullable',
            'description'     => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pre_order_product                  = PreOrderProduct::findOrFail($id);
            $pre_order_product->title           = $request->title;
            $pre_order_product->recommended_age = $request->recommended_age;
            $pre_order_product->genre           = $request->genre;
            $pre_order_product->description     = $request->description;

            if ($request->hasFile('image')) {
                if (isset($pre_order_product->image) && File::exists(public_path($pre_order_product->image))) {
                    File::delete(public_path($pre_order_product->image));
                }

                $randomString             = (string) Str::uuid();
                $Image                    = Helper::fileUpload($request->file('image'), 'pre_order_product', $request->image . '_' . $randomString);
                $pre_order_product->image = $Image;
            }

            $pre_order_product->save();
            return redirect()->route('pre_order_product.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }

    /**
     * Toggle the status of the specified Pre Order Product.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = PreOrderProduct::findOrFail($id);

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
     * Remove the specified Pre Order Product from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $pre_order_product = PreOrderProduct::findOrFail($id);

        if (isset($pre_order_product->image) && File::exists(public_path($pre_order_product->image))) {
            File::delete(public_path($pre_order_product->image));
        }

        $pre_order_product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
