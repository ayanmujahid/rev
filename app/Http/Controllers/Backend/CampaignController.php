<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CampaignController extends Controller {
    /**
     * Display a listing of the Campaign.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = Campaign::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description      = $data->description;
                    $shortDescription = strlen($description) > 20 ? substr($description, 0, 20) . '...' : $description;
                    return '<p>' . $shortDescription . '</p>';
                })
                ->addColumn('video_link', function ($data) {
                    $video_link       = $data->video_link;
                    $short_video_link = strlen($video_link) > 20 ? substr($video_link, 0, 20) . '...' : $video_link;
                    return '<span class="d-inline-block text-truncate" style="cursor: pointer; color: #333;" onmouseover="this.style.color=\'#007bff\'" onmouseout="this.style.color=\'#333\'" onclick="window.open(\'' . $video_link . '\', \'_blank\')">'
                        . $short_video_link .
                        '</span>';
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
                              <a href="' . route('campaign.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['description', 'video_link', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.campaign.index');
    }

    /**
     * Show the form for creating a new Campaign.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.campaign.create');
    }

    /**
     * Store a newly created Campaign in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string',
            'duration_date' => 'required|date|after_or_equal:today',
            'target_goal'   => 'required|numeric|gt:0',
            'achive_goal'   => 'required|numeric|lte:target_goal|gte:0',
            'video_link'    => 'required|url',
            'description'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $campaign                = new Campaign();
            $campaign->title         = $request->title;
            $campaign->duration_date = $request->duration_date;
            $campaign->target_goal   = $request->target_goal;
            $campaign->achive_goal   = $request->achive_goal;
            $campaign->video_link    = $request->video_link;
            $campaign->description   = $request->description;

            $campaign->save();
            return redirect()->route('campaign.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified Campaign.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $campaign = Campaign::findOrFail($id);
        return view('backend.layout.campaign.edit', compact('campaign'));
    }

    /**
     * Update the specified Campaign in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'title'         => 'nullable|string',
            'duration_date' => 'nullable|date',
            'target_goal'   => 'nullable|numeric',
            'achive_goal'   => 'nullable|numeric|lte:target_goal|gte:0',
            'video_link'    => 'nullable|url',
            'description'   => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $campaign                = Campaign::findOrFail($id);
            $campaign->title         = $request->title;
            $campaign->duration_date = $request->duration_date;
            $campaign->target_goal   = $request->target_goal;
            $campaign->achive_goal   = $request->achive_goal;
            $campaign->video_link    = $request->video_link;
            $campaign->description   = $request->description;

            $campaign->save();
            return redirect()->route('campaign.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }

    /**
     * Toggle the status of the specified Campaign.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = Campaign::findOrFail($id);

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
     * Remove the specified Campaign from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
