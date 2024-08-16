@extends('backend.app')

@section('title')
    Add Your Schedule
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/vendors/datatable/css/datatables.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Frequently Asked Questions & Answer</h4>
                        <p class="card-description">Setup your FAQ, please provide your<code>provide your valid data</code>.
                        </p>
                        <div style="display: flex;justify-content: end;">
                            <a href="{{ route('schedule.add') }}" class="btn btn-primary"> Add Your Schedule</a>
                        </div>
                        <div class="table-responsive mt-4 p-4">
                            <table class="table table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $i = 1; ?>
                                        @foreach($schedules as $schedule)
                                    <tr>
                                        
                                         <td>{{ $i++ }}</td>
                                         <td>{{ $schedule->meet_date }}</td>
                                         <td> 
                                             <select>@foreach ($schedule->times as $time)
                                             <option>{{ date('h:i A', strtotime($time->time_slots)) }}</option>
                                             @endforeach
                                         </select>
                                           </td>
                                         <!--<td>{{ date('h:i A', strtotime($schedule->meet_time)) }}</td>-->
                                         <td>{{ $schedule->status == 0 ? 'Available' : 'Booked' }}</td>
                                         <td>
                                             <a class="dropdown-item"
                                                        href="{{ route('schedule.edit', $schedule->id) }}"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('schedule.delete', $schedule->id) }}"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Delete</a>
                                         </td>
                                    </tr>
                                         @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection