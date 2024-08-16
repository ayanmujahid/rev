<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\UpcomingProject;
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

class UpcomingProjectController extends Controller {
    /**
     * Display a listing of the Upcoming Project.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = UpcomingProject::latest();
            return DataTables::of($data)
                ->addIndexColumn()
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
                              <a href="' . route('upcomingproject.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['description', 'image', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.upcoming_projects.index');
    }

    /**
     * Show the form for creating a new upcoming project.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.upcoming_projects.create');
    }

    /**
     * Store a newly created upcoming project in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'description' => 'nullable|string',
            'releas_date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $upcomingproject              = new UpcomingProject();
            $upcomingproject->title       = $request->title;
            $upcomingproject->description = $request->description;
            $upcomingproject->releas_date = $request->releas_date;

            $randomString           = (string) Str::uuid();
            $Image                  = Helper::fileUpload($request->file('image'), 'upcomingproject', $request->image . '_' . $randomString);
            $upcomingproject->image = $Image;

            $upcomingproject->save();
            return redirect()->route('upcomingproject.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified Upcoming Project.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $upcomingproject = UpcomingProject::findOrFail($id);
        return view('backend.layout.upcoming_projects.edit', compact('upcomingproject'));
    }

    /**
     * Update the specified upcoming project in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'description' => 'nullable|string',
            'releas_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $upcomingproject              = UpcomingProject::findOrFail($id);
            $upcomingproject->title       = $request->title;
            $upcomingproject->description = $request->description;
            $upcomingproject->releas_date = $request->releas_date;

            if ($request->hasFile('image')) {
                if ($upcomingproject->image && File::exists(public_path($upcomingproject->image))) {
                    File::delete(public_path($upcomingproject->image));
                }

                $randomString           = (string) Str::uuid();
                $Image                  = Helper::fileUpload($request->file('image'), 'upcomingproject', $request->image . '_' . $randomString);
                $upcomingproject->image = $Image;
            }

            $upcomingproject->save();
            return redirect()->route('upcomingproject.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');

        }
    }

    /**
     * Toggle the status of the specified Upcoming Project.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = UpcomingProject::findOrFail($id);

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
     * Remove the specified Upcoming Project from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $upcomingproject = UpcomingProject::findOrFail($id);

        if (isset($upcomingproject->image) && File::exists(public_path($upcomingproject->image))) {
            File::delete(public_path($upcomingproject->image));
        }

        $upcomingproject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
