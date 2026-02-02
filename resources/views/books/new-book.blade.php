@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')

    <div class="container my-2  py-2">
        {{-- title section --}}
        <div class="row mb-3 border-bottom">
            <h3>Add New Book</h3>
        </div>
        {{-- end title section --}}
        {{-- form area --}}
        <form>
            {{-- 1st row --}}
            <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                {{-- cover image  --}}
                <div class="col-lg-2 col-md-3 col-sm-12 p-2 bg-gradient rounded-4 d-flex align-items-center">
                    <div class="w-100 h-auto position-relative">
                        <img src="..." class="img-fluid rounded-top w-100" alt=""
                            onerror="this.src='{{ asset('images/placeholder-image-book.svg') }}'" />
                        <button class="btn btn-secondary position-absolute bottom-0 end-0 rounded-pill"
                            title="Edit Cover Image">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
                {{-- end cover image --}}
                <div class="col  ms-md-3 ms-0 p-2">
                    <div class="mb-3">
                        <label for="book-id" class="form-label pe-none">Book ID</label>
                        <input type="text" id="book-id" class="form-control pe-none" placeholder="Auto Generate"
                            value="#AUTO-GENERATE" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="book-title" class="form-label">Book Title</label>
                        <input type="text" id="book-title" class="form-control" placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label for="book-author" class="form-label">Book Author</label>
                        <input type="text" id="book-author" class="form-control" placeholder="" />
                    </div>
                </div>
            </div>
            {{-- 2nd row --}}
            <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                <div class="mb-3">
                    {{-- use select2 with multiple select option and new tag create allows --}}
                    <label for="book-categories" class="form-label">Select Book Categories</label>
                    <select class="form-select" name="book-categories" id="book-categories">
                        <option>4-koma</option>
                        <option>Adventure</option>
                        <option>Si-Fi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="book-added" class="form-label">Date Added</label>
                    <input type="date" class="form-control" name="book-added" id="book-added" />
                </div>
                <div class="mb-3">
                    <label for="book-remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" name="book-remarks" id="book-remarks" rows="3"></textarea>
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
