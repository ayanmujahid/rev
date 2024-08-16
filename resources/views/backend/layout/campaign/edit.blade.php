@extends('backend.app')

@section('title', 'Update Campaign')

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
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
                        <h4 class="card-title">Update Campaign</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('campaign.update', ['id' => $campaign->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text"
                                        class="form-control form-control-md border-left-0 @error('title') is-invalid @enderror"
                                        placeholder="Please enter your title" name="title" id="title"
                                        value="{{ old('title', $campaign->title) }}">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="duration_date">Duration Date:</label>
                                    <input type="date"
                                        class="form-control form-control-md border-left-0 @error('duration_date') is-invalid @enderror"
                                        name="duration_date" id="duration_date"
                                        value="{{ old('duration_date', $campaign->duration_date) }}">
                                    @error('duration_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="target_goal">Target Goal:</label>
                                            <input type="number"
                                                class="form-control form-control-md border-left-0 @error('target_goal') is-invalid @enderror"
                                                placeholder="Please enter your target goal" name="target_goal"
                                                id="target_goal" value="{{ old('target_goal', $campaign->target_goal) }}">
                                            @error('target_goal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="achive_goal">Achive Goal:</label>
                                            <input type="number"
                                                class="form-control form-control-md border-left-0 @error('achive_goal') is-invalid @enderror"
                                                placeholder="Please enter your achive goal" name="achive_goal"
                                                id="achive_goal" value="{{ old('achive_goal', $campaign->achive_goal) }}">
                                            @error('achive_goal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="video_link">Video Link:</label>
                                    <input type="url"
                                        class="form-control form-control-md border-left-0 @error('video_link') is-invalid @enderror"
                                        placeholder="Please enter your video link" name="video_link" id="video_link"
                                        value="{{ old('video_link', $campaign->video_link) }}">
                                    @error('video_link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                        {{ old('description', $campaign->description) }}
                                    </textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('campaign.index') }}" class="btn btn-danger">Cancel</a>
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
