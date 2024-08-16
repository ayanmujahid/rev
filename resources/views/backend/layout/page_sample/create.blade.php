@extends('backend.app')

@section('title', 'Create Page Sample')

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Page Sample</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('page_sample.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="image">Image:</label>
                                        <input type="file" required
                                            class="form-control form-control-md border-left-0 dropify @error('image') is-invalid @enderror"
                                            name="image" id="image" value="{{ old('image') }}">
                                        @error('image')
                                            <span class="text-danger" role="alert">
                                                <strong>Image is Required and size should not exceed 4MB.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('page_sample.index') }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush
