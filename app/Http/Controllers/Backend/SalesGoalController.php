<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SalesGoal;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SalesGoalController extends Controller {
    /**
     * Display a listing of the sales goal.
     *
     * @param Request $request
     * @return View|Factory|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | Factory | JsonResponse {
        if ($request->ajax()) {
            $data = SalesGoal::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description      = $data->description;
                    $shortDescription = strlen($description) > 20 ? substr($description, 0, 20) . '...' : $description;
                    return '<p>' . $shortDescription . '</p>';
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
                              <a href="' . route('sales.goal.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['description', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.sales_goal.index');
    }

    /**
     * Show the form for creating a new sales goal.
     *
     * @return View|Factory
     */
    public function create(): View | Factory {
        return view('backend.layout.sales_goal.create');
    }

    /**
     * Store a newly created sales goal in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'sales_target' => 'required|numeric|gte:0',
            'description'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $salesGoal               = new SalesGoal();
            $salesGoal->sales_target = $request->sales_target;
            $salesGoal->description  = $request->description;

            $salesGoal->save();
            return redirect()->route('sales.goal.index')->with('t-success', 'Create successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to create');
        }
    }

    /**
     * Show the form for editing the specified sales goal.
     *
     * @param  int  $id
     * @return View|Factory
     */
    public function edit(int $id): View | Factory {
        $salesGoal = SalesGoal::findOrFail($id);
        return view('backend.layout.sales_goal.edit', compact('salesGoal'));
    }

    /**
     * Update the specified sales goal in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'sales_target' => 'nullable|numeric|gte:0',
            'description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $salesGoal               = SalesGoal::findOrFail($id);
            $salesGoal->sales_target = $request->sales_target;
            $salesGoal->description  = $request->description;

            $salesGoal->save();
            return redirect()->route('sales.goal.index')->with('t-success', 'Update successfully');
        } catch (Exception) {
            return redirect()->back()->with('t-error', 'Failed to update');
        }
    }

    /**
     * Change the status of the specified sales goal.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = SalesGoal::findOrFail($id);

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
     * Remove the specified sales goal from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $salesGoal = SalesGoal::findOrFail($id);

        $salesGoal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
