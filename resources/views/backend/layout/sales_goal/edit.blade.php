@extends('backend.app')

@section('title', 'Update Sales Goal')

@push('style')
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Sales Goal</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('sales.goal.update', ['id' => $salesGoal->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="sales_target">Sales Target:</label>
                                    <input type="number" required
                                        class="form-control form-control-md border-left-0 @error('sales_target') is-invalid @enderror"
                                        placeholder="Please enter your sales target" name="sales_target"
                                        id="sales_target"
                                        value="{{ old('sales_target', $salesGoal->sales_target) }}">
                                    @error('sales_target')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                        {{ $salesGoal->description }}
                                    </textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('sales.goal.index') }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
