<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\LatestVideo;
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

class LatestVideoController extends Controller {
    /**
     * Display a listing of the Latest Video.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = LatestVideo::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('video', function ($data) {
                    $url = asset($data->video);
                    return '<video width="250" height="140" controls>
                                <source src="' . $url . '" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>';
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
                              <a href="' . route('latest_video.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['video', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.latest_video.index');
    }

    /**
     * Show the form for creating a Latest Video.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.latest_video.create');
    }

    /**
     * Store a newly created Latest Video in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
    $validator = Validator::make($request->all(), [
        'video' => 'required|mimes:mp4,mpeg,quicktime,avi|max:102400',
        'vid_thumbnails' => 'required|image|max:10240' // Assuming there is a validation rule for thumbnails
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $latest_video = new LatestVideo();

        $randomString = (string) Str::uuid();

        // Upload the video file
        $videoPath = Helper::fileUpload($request->file('video'), 'latest_video', $randomString);
        $latest_video->video = $videoPath;

        // Upload the thumbnail file
        $thumbnailPath = Helper::fileUpload($request->file('vid_thumbnails'), 'latest_video', $randomString . '_thumb');
        $latest_video->vid_thumbnails = $thumbnailPath;

        // Save the latest video record
        $latest_video->save();

        return redirect()->route('latest_video.index')->with('t-success', 'Created successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('t-error', 'Failed to create');
    }
}

    /**
     * Show the form for editing the Latest Video.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $latest_video = LatestVideo::findOrFail($id);
        return view('backend.layout.latest_video.edit', compact('latest_video'));
    }

    /**
     * Update the specified Latest Video in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
    $validator = Validator::make($request->all(), [
        'video' => 'nullable|mimes:mp4,mpeg,quicktime,avi|max:102400',
        'vid_thumbnails' => 'nullable|image|max:10240' // Adding validation rule for thumbnails
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $latest_video = LatestVideo::findOrFail($id);

        $randomString = (string) Str::uuid();

        if ($request->hasFile('video')) {
            // Delete old video if it exists
            if ($latest_video->video && File::exists(public_path($latest_video->video))) {
                File::delete(public_path($latest_video->video));
            }

            // Upload new video
            $videoPath = Helper::fileUpload($request->file('video'), 'latest_video', $randomString);
            $latest_video->video = $videoPath;
        }

        if ($request->hasFile('vid_thumbnails')) {
            // Delete old thumbnail if it exists
            if ($latest_video->vid_thumbnails && File::exists(public_path($latest_video->vid_thumbnails))) {
                File::delete(public_path($latest_video->vid_thumbnails));
            }

            // Upload new thumbnail
            $thumbnailPath = Helper::fileUpload($request->file('vid_thumbnails'), 'latest_video', $randomString . '_thumb');
            $latest_video->vid_thumbnails = $thumbnailPath;
        }

        // Save the updated latest video record
        $latest_video->save();

        return redirect()->route('latest_video.index')->with('t-success', 'Updated successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('t-error', 'Failed to update');
    }
}

    /**
     * Toggle the status of the Latest Video.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = LatestVideo::findOrFail($id);

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
     * Remove the Latest Video from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $latest_video = LatestVideo::findOrFail($id);

        if (isset($latest_video->video) && File::exists(public_path($latest_video->video))) {
            File::delete(public_path($latest_video->video));
        }

        $latest_video->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
