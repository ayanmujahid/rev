@extends('backend.app')

@section('title', 'Create Latest Video')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Latest Video</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('latest_video.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="video">Video:</label>
                                        <input type="file" required
                                            class="form-control form-control-md border-left-0 dropify @error('video') is-invalid @enderror"
                                            name="video" id="video" value="{{ old('video') }}" accept="video/*">
                                        @error('video')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="vid_thumbnails">Video Thumbnail:</label>
                                        <input type="file" required
                                            class="form-control form-control-md border-left-0 dropify @error('vid_thumbnails') is-invalid @enderror"
                                            name="vid_thumbnails" id="vid_thumbnails" value="{{ old('vid_thumbnails') }}" accept="vid_thumbnails/*">
                                        @error('vid_thumbnails')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('latest_video.index') }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
