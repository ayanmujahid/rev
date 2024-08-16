<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscribeController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Subscribe::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('backend.layout.subscribes.index');
    }

    public function destroy(int $id) {
        $subscribe = Subscribe::findOrFail($id);

        $subscribe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
