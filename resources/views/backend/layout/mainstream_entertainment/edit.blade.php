@extends('backend.app')

@section('title', 'Update mainstream entertainment')

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Mainstream Entertainment</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your<code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample"action="{{ route('mainstream.entertainment.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id"
                                    value="{{ isset($MainstreamEntertainment->id) ? $MainstreamEntertainment->id : '' }}"
                                    hidden>
                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text"
                                        class="form-control form-control-md border-left-0 @error('title') is-invalid @enderror"
                                        placeholder="Please enter your title" name="title"
                                        value="{{ isset($MainstreamEntertainment->title) ? $MainstreamEntertainment->title : '' }}"
                                        required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Image:</label>
                                        <input type="file" class="dropify @error('image') is-invalid @enderror"
                                            name="image" id="image" data-allowed-file-extensions="png jpg jpeg"
                                            data-default-file="{{ isset($MainstreamEntertainment->image) ? asset($MainstreamEntertainment->image) : '' }}"/>

                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('mainstream.entertainment.index') }}" class="btn btn-danger ">Cancel</a>

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
        $('.dropify').dropify();
    </script>
@endpush
