@extends('backend.app')

@section('title', 'Update Latest Video')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Latest Video</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample"
                                action="{{ route('latest_video.update', ['id' => $latest_video->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="video">Video:</label>
                                        <input type="file"
                                            class="form-control form-control-md border-left-0 dropify @error('video') is-invalid @enderror"
                                            name="video" id="video" accept="video/*">
                                        @error('video')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    
                                    <div class="col">
                                        <label for="video">Video Thumbnail:</label>
                                        <input type="file"
                                            class="form-control form-control-md border-left-0 dropify @error('vid_thumbnails') is-invalid @enderror"
                                            name="vid_thumbnails" id="vid_thumbnails" accept="vid_thumbnails/*">
                                        @error('vid_thumbnails')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('latest_video.index') }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
