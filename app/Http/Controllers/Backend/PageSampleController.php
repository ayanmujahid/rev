<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\PageSample;
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

class PageSampleController extends Controller {
    /**
     * Display a listing of the Page Sample.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = PageSample::latest();
            return DataTables::of($data)
                ->addIndexColumn()
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
                              <a href="' . route('page_sample.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.page_sample.index');
    }

    /**
     * Show the form for creating a Page Sample.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.page_sample.create');
    }

    /**
     * Store a newly created Page Sample in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $page_sample = new PageSample();

            $randomString       = (string) Str::uuid();
            $Image              = Helper::fileUpload($request->file('image'), 'page_sample', $request->image . '_' . $randomString);
            $page_sample->image = $Image;

            $page_sample->save();
            return redirect()->route('page_sample.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified Page Sample.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $page_sample = PageSample::findOrFail($id);
        return view('backend.layout.page_sample.edit', compact('page_sample'));
    }

    /**
     * Update the specified Page Sample in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $page_sample = PageSample::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($page_sample->image && File::exists(public_path($page_sample->image))) {
                    File::delete(public_path($page_sample->image));
                }

                $randomString       = (string) Str::uuid();
                $Image              = Helper::fileUpload($request->file('image'), 'page_sample', $request->image . '_' . $randomString);
                $page_sample->image = $Image;
            }

            $page_sample->save();
            return redirect()->route('page_sample.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');

        }
    }

    /**
     * Toggle the status of the specified Page Sample.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = PageSample::findOrFail($id);

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
     * Remove the specified Page Sample Product from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $page_sample = PageSample::findOrFail($id);

        if (isset($page_sample->image) && File::exists(public_path($page_sample->image))) {
            File::delete(public_path($page_sample->image));
        }

        $page_sample->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
