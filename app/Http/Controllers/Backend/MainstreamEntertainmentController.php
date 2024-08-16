<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\MainstreamEntertainment;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MainstreamEntertainmentController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = MainstreamEntertainment::latest();
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
                                  <a href="' . route('mainstream.entertainment.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
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
        return view('backend.layout.mainstream_entertainment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|View
     */
    public function create() {
        return view('backend.layout.mainstream_entertainment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $MainstreamEntertainment        = new MainstreamEntertainment();
            $MainstreamEntertainment->title = $request->title;

            $randomString = Str::random(20);

            $Image = Helper::fileUpload($request->file('image'), 'mainstream-entertainment', $request->image . '_' . $randomString);

            $MainstreamEntertainment->image = $Image;
            $MainstreamEntertainment->save();

            return redirect()->route('mainstream.entertainment.index')->with("t-success", "Created Successfully");
        } catch (Exception) {
            return redirect()->route('mainstream.entertainment.index')->with("t-error", "Failed to create");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|View
     */
    public function edit(int $id) {
        $MainstreamEntertainment = MainstreamEntertainment::findOrFail($id);
        return view('backend.layout.mainstream_entertainment.edit', compact('MainstreamEntertainment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);
        
        try {

            $MainstreamEntertainment        = MainstreamEntertainment::findOrFail($request->id);
            $MainstreamEntertainment->title = $request->title;

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                if ($MainstreamEntertainment ->image && File::exists(public_path($MainstreamEntertainment ->image))) {
                    File::delete(public_path($MainstreamEntertainment ->image));
                }
                $randomString   = (string) Str::uuid();
                $Image          = Helper::fileUpload($request->file('image'), 'MainstreamEntertainment', $request->image . '_' . $randomString);
                $MainstreamEntertainment->image = $Image;
            }

            $MainstreamEntertainment->save();

            return redirect()->route('mainstream.entertainment.index')->with('t-success', 'Updated successfully.');
        } catch (Exception) {
            return redirect()->route('mainstream.entertainment.index')->with('t-error', 'Failed to update .');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id) {
        $MainstreamEntertainment = MainstreamEntertainment::findOrFail($id);
        if (isset($MainstreamEntertainment->image)) {
            unlink($MainstreamEntertainment->image);
        }
        $MainstreamEntertainment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    /**
     * Change the status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id) {
        $data = MainstreamEntertainment::where('id', $id)->first();

        if ($data->status == 'active') {
            // If the current status is active, change it to inactive
            $data->status = 'inactive';
            $data->save();

            // Return JSON response indicating success with message and updated data
            return response()->json([
                'error'   => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            // If the current status is inactive, change it to active
            $data->status = 'active';
            $data->save();

            // Return JSON response indicating success with message and updated data
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }
}
