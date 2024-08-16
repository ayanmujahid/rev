<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\HappyUser;
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

class HappyUserController extends Controller {
    /**
     * Display a listing of the Happy Users.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = HappyUser::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description      = $data->description;
                    $shortDescription = strlen($description) > 20 ? substr($description, 0, 20) . '...' : $description;
                    return '<p>' . $shortDescription . '</p>';
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
                              <a href="' . route('happyuser.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
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
        return view('backend.layout.happy_users.index');
    }

    /**
     * Show the form for creating a new Happy User.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.happy_users.create');
    }

    /**
     * Store a newly created Happy User in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'rating'      => 'required|numeric',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'short_title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $happyuser              = new HappyUser();
            $happyuser->rating      = $request->rating;
            $happyuser->short_title = $request->short_title;
            $happyuser->description = $request->description;
            $happyuser->type = $request->type;

            $randomString     = (string) Str::uuid();
            $Image            = Helper::fileUpload($request->file('image'), 'happyuser', $request->image . '_' . $randomString);
            $happyuser->image = $Image;

            $happyuser->save();
            return redirect()->route('happyuser.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified Happy User.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $happyuser = HappyUser::findOrFail($id);
        return view('backend.layout.happy_users.edit', compact('happyuser'));
    }

    /**
     * Update the specified Happy User in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'rating'      => 'nullable|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'short_title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $happyuser              = HappyUser::findOrFail($id);
            $happyuser->rating      = $request->rating;
            $happyuser->short_title = $request->short_title;
            $happyuser->description = $request->description;

            if ($request->hasFile('image')) {
                if ($happyuser->image && File::exists(public_path($happyuser->image))) {
                    File::delete(public_path($happyuser->image));
                }

                $randomString     = (string) Str::uuid();
                $Image            = Helper::fileUpload($request->file('image'), 'happyuser', $request->image . '_' . $randomString);
                $happyuser->image = $Image;
            }

            $happyuser->save();
            return redirect()->route('happyuser.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');

        }
    }

    /**
     * Toggle the status of the specified Happy User.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = HappyUser::findOrFail($id);

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
     * Remove the specified Happy User from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $happyuser = HappyUser::findOrFail($id);

        if (isset($happyuser->image) && File::exists(public_path($happyuser->image))) {
            File::delete(public_path($happyuser->image));
        }

        $happyuser->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
