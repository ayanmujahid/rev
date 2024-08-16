@extends('backend.app')

@section('title', 'Create Gift')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Gift</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('gifts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="title">Title:</label>
                                        <input type="text" required
                                            class="form-control form-control-md border-left-0 @error('title') is-invalid @enderror"
                                            name="title" id="title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="img_path">Image:</label>
                                        <input type="file" required
                                            class="form-control form-control-md border-left-0 dropify @error('img_path') is-invalid @enderror"
                                            name="img_path" id="img_path" value="{{ old('img_path') }}" accept="image/*">
                                        @error('img_path')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('gifts.index') }}" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection