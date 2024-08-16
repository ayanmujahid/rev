<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\LatestVideo;
use App\Models\Gift;
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

class Gift extends Controller {
    /**
     * Display a listing of the Latest Video.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
    if ($request->ajax()) {
        $data = Gift::latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($data) {
                return '<div>' . $data->title . '</div>';
            })
            ->addColumn('img_path', function ($data) {
                $url = asset($data->img_path);
                return '<img src="' . $url . '" width="250" height="140" alt="Image">';
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
                          <a href="' . route('gift.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                          <i class="bi bi-pencil"></i>
                          </a>
                          <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                          <i class="bi bi-trash"></i>
                        </a>
                        </div>';
            })
            ->rawColumns(['title', 'img_path', 'status', 'action'])
            ->make();
    }
    return view('backend.layout.gifts.index');
}

/**
 * Show the form for creating a Gift.
 *
 * @return View|Factory
 */
public function create(): View | Factory {
    return view('backend.layout.gifts.create');
}

/**
 * Store a newly created Gift in storage.
 *
 * @param Request $request
 * @return RedirectResponse
 */
public function store(Request $request): RedirectResponse {
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'img_path' => 'required|image|max:10240'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $gift = new Gift();

        // Set the title
        $gift->title = $request->title;

        // Upload the image file
        $randomString = (string) Str::uuid();
        $imgPath = Helper::fileUpload($request->file('img_path'), 'gifts', $randomString . '_img');
        $gift->img_path = $imgPath;

        // Save the gift record
        $gift->save();

        return redirect()->route('gifts.index')->with('t-success', 'Created successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('t-error', 'Failed to create');
    }
}

/**
 * Show the form for editing the Gift.
 *
 * @param  int  $id
 * @return View|Factory
 */
public function edit(int $id): View | Factory {
    $gift = Gift::findOrFail($id);
    return view('backend.layout.gifts.edit', compact('gift'));
}

/**
 * Update the specified Gift in storage.
 *
 * @param Request $request
 * @param  int  $id
 * @return RedirectResponse
 */
public function update(Request $request, int $id): RedirectResponse {
    $validator = Validator::make($request->all(), [
        'title' => 'nullable|string|max:255',
        'img_path' => 'nullable|image|max:10240'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $gift = Gift::findOrFail($id);

        // Update the title if provided
        if ($request->has('title')) {
            $gift->title = $request->title;
        }

        $randomString = (string) Str::uuid();

        if ($request->hasFile('img_path')) {
            // Delete old image if it exists
            if ($gift->img_path && File::exists(public_path($gift->img_path))) {
                File::delete(public_path($gift->img_path));
            }

            // Upload new image
            $imgPath = Helper::fileUpload($request->file('img_path'), 'gifts', $randomString . '_img');
            $gift->img_path = $imgPath;
        }

        // Save the updated gift record
        $gift->save();

        return redirect()->route('gifts.index')->with('t-success', 'Updated successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('t-error', 'Failed to update');
    }
}

/**
 * Toggle the status of the Gift.
 *
 * @param  int  $id
 * @return JsonResponse
 */
public function status(int $id): JsonResponse {
    $gift = Gift::findOrFail($id);

    if ($gift->status == 'active') {
        $gift->status = 'inactive';
        $gift->save();
        return response()->json([
            'error'   => false,
            'message' => 'Unpublished Successfully.',
            'data'    => $gift,
        ]);
    } else {
        $gift->status = 'active';
        $gift->save();
        return response()->json([
            'success' => true,
            'message' => 'Published Successfully.',
            'data'    => $gift,
        ]);
    }
}

/**
 * Remove the Gift from storage.
 *
 * @param  int  $id
 * @return JsonResponse
 */
public function destroy(int $id): JsonResponse {
    $gift = Gift::findOrFail($id);

    if (isset($gift->img_path) && File::exists(public_path($gift->img_path))) {
        File::delete(public_path($gift->img_path));
    }

    $gift->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted successfully.',
    ]);
}

}
