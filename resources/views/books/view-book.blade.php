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
                <button class="btn btn-primary rounded-pill">
                    <i class="bi bi-pencil-square me-md-1 me-0"></i>
                    <span class="d-md-inline d-none">Edit</span>
                </button>
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
                            <img src="..." class="img-fluid rounded-top w-100" alt=""
                                onerror="this.src='{{ asset('images/placeholder-image-book.svg') }}'" />
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
                            <label for="book-title" class="form-label pe-none">Book Title</label>
                            <input type="text" id="book-title" class="form-control pe-none" placeholder="" />
                        </div>
                        <div class="mb-3">
                            <label for="book-author" class="form-label pe-none">Book Author</label>
                            <input type="text" id="book-author" class="form-control pe-none" placeholder="" />
                        </div>
                    </div>
                </div>
                {{-- 2nd row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    <div class="mb-3">
                        {{-- use select2 with multiple select option and new tag create allows --}}
                        <label for="book-categories" class="form-label pe-none">Book Categories</label>
                        <div class="row mx-1 w-100 flex-wrap">
                            <button class="btn btn-info btn-sm w-auto m-1 rounded-pill border pe-none" type="button"
                                value="0">4-koma</button>
                            <button class="btn btn-info btn-sm w-auto m-1 rounded-pill border pe-none" type="button"
                                value="0">Adventure</button>
                            <button class="btn btn-info btn-sm w-auto m-1 rounded-pill border pe-none" type="button"
                                value="0">Fantasy</button>
                            <button class="btn btn-info btn-sm w-auto m-1 rounded-pill border pe-none" type="button"
                                value="0">Si-Fi</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="book-added" class="form-label pe-none">Date Added</label>
                        <input type="date" class="form-control pe-none" name="book-added" id="book-added" />
                    </div>
                    <div class="mb-3">
                        <label for="book-remarks" class="form-label pe-none">Remarks</label>
                        <textarea class="form-control pe-none" name="book-remarks" id="book-remarks" rows="3"></textarea>
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
                                <td scope="row">R1C1</td>
                                <td>Mr.abc def</td>
                                <td>2025-02-02</td>
                                <td>2025-03-01</td>
                                <td>2025-03-04</td>
                                <td>3 days late</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- end tab section --}}
    </div>

@endsection
