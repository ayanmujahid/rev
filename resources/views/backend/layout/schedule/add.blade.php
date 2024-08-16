@extends('backend.app')

@section('title', 'Add Schedule')

@push('script')
<script>
    document.getElementById('add-time-slot').addEventListener('click', function () {
        var container = document.getElementById('time-slots-container');
        var newSlot = document.createElement('div');
        newSlot.classList.add('form-group', 'row');
        newSlot.innerHTML = `
            <div class="col">
                <input type="time" required class="form-control form-control-md border-left-0 dropify time-slot-input" name="time_slots[]">
            </div>
        `;
        container.appendChild(newSlot);
    });
</script>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Schedule</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('schedule.create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="col">
            <label for="date">Date:</label>
            <input type="date" required class="form-control form-control-md border-left-0 dropify @error('date') is-invalid @enderror" name="meet_date" id="date" value="{{ old('date') }}">
            @error('date')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div id="time-slots-container">
        <div class="form-group row">
            <div class="col">
                <label for="time">Time Slots:</label>
                <div class="input-group">
                    <input type="time" required class="form-control form-control-md border-left-0 dropify time-slot-input @error('time_slots.*') is-invalid @enderror" name="time_slots[]" id="time">
                    <button type="button" class="btn btn-success" id="add-time-slot">+</button>
                </div>
                @error('time_slots.*')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
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
