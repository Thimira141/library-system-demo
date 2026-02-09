@extends('layouts.app')

@section('title', 'View Book')

@section('content')

    <div class="container my-2  py-2">
        {{-- title section --}}
        <div class="row mb-3 border-bottom justify-content-between">
            <div class="col-auto">
                <h3>View Book</h3>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary rounded-pill" href="{{ route('books-edit-book', $book->book_id) }}">
                    <i class="bi bi-pencil-square me-md-1 me-0"></i>
                    <span class="d-md-inline d-none">Edit</span>
                </a>
            </div>
        </div>
        {{-- end title section --}}
        {{-- tab section --}}
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-pills mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="main-book-information-tab" data-bs-toggle="tab"
                    data-bs-target="#main-book-information-tab-pane" type="button" role="tab"
                    aria-controls="main-book-information-tab-pane" aria-selected="true">
                    <i class="bi bi-journal-text me-1"></i>
                    Book Information
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="book-history-tab" data-bs-toggle="tab" data-bs-target="#book-history-tab-pane"
                    type="button" role="tab" aria-controls="book-history-tab-pane" aria-selected="false">
                    <i class="bi bi-clock-history me-1"></i>
                    History
                </button>
            </li>
        </ul>
        <div class="tab-content p-2" id="myTabContent">
            {{-- 1st tab pane --}}
            <div class="tab-pane fade show active" id="main-book-information-tab-pane" role="tabpanel"
                aria-labelledby="main-book-information-tab" tabindex="0">
                {{-- 1st row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    {{-- cover image  --}}
                    <div class="col-lg-2 col-md-3 col-sm-12 p-2 bg-gradient rounded-4 d-flex align-items-center">
                        <div class="w-100 h-auto position-relative">
                            <img src="{{ Storage::url($book->book_cover_img) }}" class="img-fluid rounded-top w-100" alt=""
                                onerror="this.src='{{ asset('images/placeholder-image-book.svg') }}'" />
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
                            <label for="book_title" class="form-label pe-none">Book Title</label>
                            <input type="text" id="book_title" class="form-control pe-none" value="{{ $book->book_title }}" placeholder="" />
                        </div>
                        <div class="mb-3">
                            <label for="book_author" class="form-label pe-none">Book Author</label>
                            <input type="text" id="book_author" class="form-control pe-none" value="{{ $book->book_author }}" placeholder="" />
                        </div>
                    </div>
                </div>
                {{-- 2nd row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    <div class="mb-3">
                        {{-- use select2 with multiple select option and new tag create allows --}}
                        <label for="book-categories" class="form-label pe-none">Book Categories</label>
                        <div class="row mx-1 w-100 flex-wrap">
                            @foreach ($book->categories as $category)
                            <button class="btn btn-info btn-sm w-auto m-1 rounded-pill border pe-none" type="button"
                                value="0">{{ $category->category_name }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="book_added" class="form-label pe-none">Date Added</label>
                        <input type="date" class="form-control pe-none" name="book_added" value="{{ $book->book_added }}" id="book_added" />
                    </div>
                    <div class="mb-3">
                        <label for="book_remarks" class="form-label pe-none">Remarks</label>
                        <textarea class="form-control pe-none" name="book_remarks" id="book_remarks" rows="3">{{ $book->book_remarks }}</textarea>
                    </div>
                </div>
                {{-- end form area --}}
            </div>
            {{-- 2nd tab pane --}}
            <div class="tab-pane fade" id="book-history-tab-pane" role="tabpanel" aria-labelledby="book-history-tab"
                tabindex="0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Borrower</th>
                                <th scope="col">Borrowed Date</th>
                                <th scope="col">Return Promised Date</th>
                                <th scope="col">Returned Date</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td colspan="6" class="text-center">No Data</td>
                                {{-- <td scope="row">R1C1</td>
                                <td>Mr.abc def</td>
                                <td>2025-02-02</td>
                                <td>2025-03-01</td>
                                <td>2025-03-04</td>
                                <td>3 days late</td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- end tab section --}}
    </div>

@endsection
