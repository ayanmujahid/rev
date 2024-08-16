@extends('backend.app')

@section('title', 'Update Product')

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
                        <h4 class="card-title">Update Product</h4>
                        <p class="card-description">Setup Mainstream Entertainment, please provide your <code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample" action="{{ route('product.update', ['id' => $product->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Category:</label>
                                            <select
                                                class="form-control form-control-md border-left-0 @error('category_id') is-invalid @enderror"
                                                name="category_id" id="category_id">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Select Type:</label>
                                            <select
                                                class="form-control form-control-md border-left-0 @error('type') is-invalid @enderror"
                                                name="type" id="type">
                                                <option class="dropdown-item" value=""
                                                    {{ old('type', $product->type) == '' ? 'selected' : '' }}>Select Type
                                                </option>
                                                <option class="dropdown-item" value="Merchandise"
                                                    {{ old('type', $product->type) == 'Merchandise' ? 'selected' : '' }}>
                                                    Merchandise
                                                </option>
                                                <option class="dropdown-item" value="pre-order"
                                                {{ old('type', $product->type) == 'pre-order' ? 'selected' : '' }}>
                                                Pre-Order
                                            </option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text"
                                        class="form-control form-control-md border-left-0 @error('title') is-invalid @enderror"
                                        placeholder="Please enter your title" name="title" id="title"
                                        value="{{ old('title', $product->title ?? '') }}">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sub_title">Sub Title:</label>
                                    <input type="text"
                                        class="form-control form-control-md border-left-0 @error('sub_title') is-invalid @enderror"
                                        placeholder="Please enter your sub title" name="sub_title" id="sub_title"
                                        value="{{ old('sub_title', $product->sub_title ?? '') }}">
                                    @error('sub_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="original_price">Original Price:</label>
                                            <input type="number"
                                                class="form-control form-control-md border-left-0 @error('original_price') is-invalid @enderror"
                                                placeholder="Please enter your original_price" name="original_price"
                                                id="original_price"
                                                value="{{ old('original_price', $product->original_price ?? '') }}">
                                            @error('original_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discount_price">Discount Price:</label>
                                            <input type="number"
                                                class="form-control form-control-md border-left-0 @error('discount_price') is-invalid @enderror"
                                                placeholder="Please enter your discount_price" name="discount_price"
                                                id="discount_price"
                                                value="{{ old('discount_price', $product->discount_price ?? '') }}">
                                            @error('discount_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                        {{ $product->description ?? '' }}
                                    </textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="image">Image:</label>
                                        <input type="file"
                                            class="form-control form-control-md border-left-0 dropify @error('image') is-invalid @enderror"
                                            name="image" id="image" data-default-file="{{ asset($product->image) }}">
                                        @error('image')
                                            <span class="text-danger" role="alert">
                                                <strong>Image is Required and size should not exceed 4MB.</strong><br>
                                                <strong>Now you are seeing your previous image..</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('product.index') }}" class="btn btn-danger">Cancel</a>
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

    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
