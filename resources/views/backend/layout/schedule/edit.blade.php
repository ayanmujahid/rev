@extends('backend.app')

@section('title', 'Update Schedule')

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('add-time-slot').addEventListener('click', function () {
            var container = document.getElementById('time-slots-container');
            var newSlot = document.createElement('div');
            newSlot.classList.add('form-group', 'row');
            newSlot.innerHTML = `
                <div class="col">
                    <input type="time" required class="form-control form-control-md border-left-0 dropify time-slot-input" name="time_slots[]">
                    <button type="button" class="btn btn-danger btn-sm remove-time-slot">Remove</button>
                </div>
            `;
            container.appendChild(newSlot);

            // Add event listener to remove button
            newSlot.querySelector('.remove-time-slot').addEventListener('click', function () {
                newSlot.remove();
            });
        });

        // Add event listeners to existing remove buttons
        document.querySelectorAll('.remove-time-slot').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.form-group').remove();
            });
        });
    });
</script>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Schedule</h4>
                        <p class="card-description">Update the schedule with the new data.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('schedule.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $schedule->id }}">
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="date">Date:</label>
                                        <input type="date" required
                                            class="form-control form-control-md border-left-0 dropify @error('meet_date') is-invalid @enderror"
                                            name="meet_date" id="date" value="{{ $schedule->meet_date }}">
                                        @error('meet_date')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="time-slots-container">
                                    <label for="time">Time Slots:</label>
                                    @foreach ($schedule->times as $time)
                                    <div class="form-group row">
                                        <div class="col">
                                            <input type="time" required class="form-control form-control-md border-left-0 dropify time-slot-input" name="time_slots[]" value="{{ $time->time_slots }}">
                                            <button type="button" class="btn btn-danger btn-sm remove-time-slot">Remove</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success" id="add-time-slot">Add Time Slot</button>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('schedule.index') }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
