@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')

    <div class="container my-2  py-2">
        {{-- title section --}}
        <div class="row mb-3 border-bottom">
            <h3>Edit Book</h3>
        </div>
        {{-- end title section --}}
        {{-- form area --}}
        <form method="post" action="{{ route('books-save-edit-book', $book->book_id) }}" class="ajax-form" enctype="multipart/form-data">
            @csrf
            @method('POST')
            {{-- 1st row --}}
            <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                {{-- cover image  --}}
                <div class="col-lg-2 col-md-3 col-sm-12 p-2 bg-gradient rounded-4 d-flex align-items-center">
                    <div class="w-100 h-auto position-relative cover-image-action-btn-hover-cover">
                        <img src="{{ Storage::url($book->book_cover_img) }}" class="img-fluid rounded-top w-100"
                            alt="" id="book_cover_img-preview"
                            onerror="this.src='{{ asset('images/placeholder-image-book.svg') }}'" />
                        <label
                            class="btn btn-secondary position-absolute bottom-0 end-0 rounded-pill cover-image-action-btn opacity-0"
                            title="Edit Cover Image" for="book_cover_img">
                            <i class="bi bi-pencil-square"></i>
                        </label>
                        <input type="file" name="book_cover_img" id="book_cover_img" class="visually-hidden"
                            data-target-img="#book_cover_img-preview" accept="image/*"
                            onchange="utility.previewSelectedImage(this);">
                    </div>
                </div>
                {{-- end cover image --}}
                <div class="col  ms-md-3 ms-0 p-2">
                    <div class="mb-3">
                        <label for="book-id" class="form-label pe-none">Book ID</label>
                        <input type="text" id="book-id" class="form-control pe-none" placeholder="Auto Generate"
                            value="{{$book->book_id}}" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="book_title" class="form-label">Book Title</label>
                        <input type="text" id="book_title" name="book_title" class="form-control" value="{{ $book->book_title }}" placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label for="book_author" class="form-label">Book Author</label>
                        <input type="text" id="book_author" name="book_author" class="form-control" value="{{ $book->book_author }}" placeholder="" />
                    </div>
                </div>
            </div>
            {{-- 2nd row --}}
            <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                <div class="mb-3">
                    {{-- use select2 with multiple select option and new tag create allows --}}
                    <label for="book_categories" class="form-label">Select Book Categories</label>
                    <select class="form-select" name="book_categories[]" id="book_categories" multiple>
                        @foreach ($book->categories as $category)
                        <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="book_added" class="form-label">Date Added</label>
                    <input type="date" class="form-control" value="{{ $book->book_added }}" name="book_added" id="book_added" />
                </div>
                <div class="mb-3">
                    <label for="book_remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" name="book_remarks" id="book_remarks" rows="3">{{ $book->book_remarks }}</textarea>
                </div>
                <div class="my-3">
                    <button class="btn btn-danger me-2" type="reset">
                        Clear
                    </button>
                    <button class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
        {{-- end form area --}}
    </div>

@endsection
