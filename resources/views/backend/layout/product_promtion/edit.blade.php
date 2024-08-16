@extends('backend.app')

@section('title', 'Update Product Promotion')

@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Product Promotion</h4>
                        <p class="card-description">Setup Product Promotion, please provide your<code>valid
                                data</code>.</p>
                        <div class="mt-4">
                            <form class="forms-sample"action="{{ route('product.promotion.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id"
                                    value="{{ isset($ProductPromotion->id) ? $ProductPromotion->id : '' }}"
                                    hidden>
                                <div class="form-group">
                                    <label>Promotion Type:</label>
                                    <select class="form-control @error('promotion_type') is-invalid @enderror"
                                        name="promotion_type">
                                        <option class="dropdown-item" disabled selected>Select Type</option>
                                        <option class="dropdown-item" value="free"
                                            {{ $ProductPromotion->promotion_type == 'free' ? 'selected' : '' }}>Free
                                        </option>
                                        <option class="dropdown-item" value="limited_offer"
                                            {{ $ProductPromotion->promotion_type == 'limited_offer' ? 'selected' : '' }}>
                                            Limited Time Offer</option>
                                    </select>
                                    @error('promotion_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text"
                                        class="form-control form-control-md border-left-0 @error('title') is-invalid @enderror"
                                        placeholder="Please enter your title" name="title"
                                        value="{{ isset($ProductPromotion->title) ? $ProductPromotion->title : '' }}"
                                        required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                        placeholder="Please enter short description" name="short_description">{{ isset($ProductPromotion->short_description) ? $ProductPromotion->short_description : '' }}</textarea>
                                    @error('short_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Image:</label>
                                        <input type="file"
                                            class="form-control form-control-md border-left-0 dropify @error('image') is-invalid @enderror"
                                            name="image" id="image" data-allowed-file-extensions="png jpg jpeg"
                                            data-default-file="{{ isset($ProductPromotion->image) ? asset($ProductPromotion->image) : '' }}" />
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('product.promotion.index') }}" class="btn btn-danger ">Cancel</a>

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
