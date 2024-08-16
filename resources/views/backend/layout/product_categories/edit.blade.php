@extends('backend.app')

@section('title', 'Update Category')

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Category</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample"
                                action="{{ route('productcategory.update', ['id' => $productcategory->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="category_type">Category Type:</label>
                                    <input type="text"
                                        class="form-control form-control-md border-left-0 @error('category_type') is-invalid @enderror"
                                        placeholder="Please enter your category_type" name="category_type"
                                        id="category_type"
                                        value="{{ old('category_type', $productcategory->category_type) }}">
                                    @error('category_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="category_image">Category Image:</label>
                                        <input type="file"
                                            class="form-control form-control-md border-left-0 dropify @error('category_image') is-invalid @enderror"
                                            name="category_image" id="category_image"
                                            data-default-file="{{ asset($productcategory->category_image) }}">
                                        @error('category_image')
                                            <span class="text-danger" role="alert">
                                                <strong>Category Image is Required and size should not exceed 4MB.</strong><br>
                                                <strong>Now you are seeing your previous Category Image..</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('productcategory.index') }}" class="btn btn-danger">Cancel</a>
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
