<?php

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Schedule;
use App\Models\Time;
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


class ScheduleController extends Controller {
    
     public function index(Request $request) {
    $schedules = Schedule::all();
    
    return view('backend.layout.schedule.index', compact('schedules'));
}

public function add()
    {
        // $faq_type = FaqType::where('is_active',1)->get();
        return view('backend.layout.schedule.add')->with('title', 'Add Schedule');
    }
  
    public function create(Request $request)
{
    $request->validate([
        'meet_date' => 'required|date',
        'time_slots.*' => 'required|date_format:H:i',
    ]);

    // Create schedule
    $schedule = Schedule::create([
        'meet_date' => $request->input('meet_date'),
    ]);

    // Create time slots and associate them with the schedule
    foreach ($request->input('time_slots') as $timeSlot) {
        $schedule->times()->create([
            'time_slots' => $timeSlot,
        ]);
    }

    return redirect()->route('schedule.index')->with('t-success', 'Schedule Created Successfully!!');
}

    public function edit($id)
    {
        $schedule = Schedule::where('id', $id)->first();
        // $faq_type = FaqType::where('is_active',1)->get();
        return view('backend.layout.schedule.edit')->with('title', 'Edit Schedule')->with(compact('schedule'));
    }

    public function save(Request $request)
{
    $request->validate([
        'id' => 'required|exists:schedules,id',
        'meet_date' => 'required|date',
        'time_slots.*' => 'required|date_format:H:i',
    ]);

    // Update the schedule
    $schedule = Schedule::findOrFail($request->id);
    $schedule->update([
        'meet_date' => $request->input('meet_date'),
    ]);

    // Delete existing time slots and create new ones
    $schedule->times()->delete();

    foreach ($request->input('time_slots') as $timeSlot) {
        $schedule->times()->create([
            'time_slots' => $timeSlot,
        ]);
    }

    return redirect()->route('schedule.index')->with('t-success', 'Schedule Updated Successfully!!');
}
    
    
    public function suspend($id)
    {
        $schedule = Schedule::where('id', $id)->first();
        if ($schedule->is_active == 0) {
            $schedule->is_active = 1;
            $schedule->save();
            return redirect()->route('schedule.index')->with('t-success', 'Schedule Activated Successfuly!!');
        } else {
            $schedule->is_active = 0;
            $schedule->save();
            return redirect()->route('schedule.index')->with('t-success', 'Schedule Suspended Successfuly!!');
        }
    }
    
    
    public function delete($id)
    {
        $schedule = Schedule::where('id', $id)->delete();
        return redirect()->route('schedule.index')->with('t-success', 'Schedule Deleted Successfuly!!');
    }
    
    
    //  public function getTimeSlots(Request $request)
    // {
    //     $date = $request->input('date');
    //     $schedules = Schedule::where('meet_date', $date)->get();
        
    //     $timeSlots = [];
    //     foreach ($schedules as $schedule) {
    //         $slots = Time::where('meet_schedule_id', $schedule->id)->get();
    //         foreach ($slots as $slot) {
    //             $timeSlots[] = [
    //                 'time_slots' => $slot->time_slots,
    //                 'schedule_id' => $schedule->id
    //             ];
    //         }
    //     }

    //     return response()->json($timeSlots);
    // }
    
public function getTimeSlots(Request $request)
{
    $date = $request->input('date');
    $schedules = Schedule::where('meet_date', $date)->get();
    
    $timeSlots = [];
    foreach ($schedules as $schedule) {
        $slots = Time::where('meet_schedule_id', $schedule->id)->get();
        foreach ($slots as $slot) {
            $timeSlots[] = [
                'time_slots' => $slot->time_slots,
                'id' => $slot->id,
                'status' => $slot->status // Include the status of the time slot
            ];
        }
    }

    return response()->json($timeSlots);
}
    
    
     
   public function update_booking(Request $request)
{
    // Validate the request
    $request->validate([
        'meet_schedule_id' => 'required|exists:meeting_time,id',
        'status' => 'required|integer'
    ]);

    // Log incoming data
    \Log::info('Request Data: ', $request->all());

    // Find the schedule by ID
    $schedule = Time::find($request->meet_schedule_id);

    if (!$schedule) {
        \Log::info('Schedule not found for ID: ' . $request->meet_schedule_id);
        return redirect('/')->with('error', 'Schedule not found.');
    }

    // Update the status
    $schedule->status = $request->status;
    $schedule->save();

    // Log successful update
    \Log::info('Updated Schedule ID: ' . $schedule->id . ' with Status: ' . $schedule->status);

    // Redirect back with a success message
    return redirect('/')->with('success', 'Schedule status updated successfully.');
}




    
}