@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container my-2  py-2">
        {{-- search box --}}
        <div class="row mb-3 p-3 shadow-sm rounded-2 bg-body-tertiary">
            <div class="col-md col-sm-12">
                <div class="input-group input-group-lg bg-body">
                    <input type="search" class="form-control" placeholder="Author... Book name..." id="searchBox">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#contentId" aria-expanded="false" aria-controls="contentId">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-auto col-sm-12 mt-3 mt-md-0">
                <a class="btn btn-lg btn-secondary w-100" href="{{ route('books-new-book') }}">
                    <i class="bi bi-journal-plus me-1"></i>
                    New Book
                </a>
            </div>
        </div>
        {{-- end search box --}}
        {{-- search box filters --}}
        <div class="row mb-3 bg-body-tertiary rounded shadow-sm">
            <div class="collapse mx-3" id="contentId">
                <div class="py-3">
                    <p>
                        <span class="h6">Book Categories</span>
                        <span class="fst-italic">[
                            How Categories Work, based on color
                            <button class="btn badge m-1 rounded-pill border" type="button" value="0">Ignore</button>
                            <button class="btn badge m-1 rounded-pill border btn-success" type="button"
                                value="1">Include</button>
                            <button class="btn badge m-1 rounded-pill border btn-danger" type="button"
                                value="2">Exclude</button>
                            ]</span>
                    </p>
                    <div class="row mb-3 pb-1 w-100 border-bottom flex-wrap">
                        @foreach ($categories as $category)
                            <button class="btn btn-sm w-auto m-1 rounded-pill border iei-btn" data-name="category"
                                data-value="{{ $category->id }}" type="button"
                                value="0">{{ $category->category_name }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- end search box filters --}}
        {{-- result area --}}
        <div class="row p-2 mb-3 shadow-sm rounded-2 bg-body-tertiary">
            <div class="table-responsive">
                <table class="table table-hover" id="booksTable">
                    <thead>
                        <tr>
                            <th scope="col">Book Cover</th>
                            <th scope="col">BookID</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Book Author</th>
                            <th scope="col">Book Categories</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- end result area --}}
    </div>
    <div class="visually-hidden">
        <form action="" method="POST" id="delete-dt-main-form" class="ajax-form" data-confirm="true"
            data-confirm-message="Are you sure you want to delete this book?">
            @csrf
            @method('DELETE')
            <input type="hidden" id="table-selector" name="book_id" value="">
        </form>
    </div>
    <script>
        window.routes = {
            booksView: @json(route('books-view-book', ':id')),
            booksEdit: @json(route('books-edit-book', ':id')),
            booksDestroy: @json(route('books-delete-book', ':id')),
            bookImgPlaceholder: @json(asset('images/placeholder-image-book.svg')),
        };
    </script>

@endsection
