@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container my-2  py-2">
        {{-- search box --}}
        <div class="row mb-3 p-3 shadow-sm rounded-2 bg-body-tertiary">
            <div class="col-md col-sm-12">
                <div class="input-group input-group-lg bg-body">
                    <input type="text" class="form-control" placeholder="Author... Book name...">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#contentId" aria-expanded="false" aria-controls="contentId">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button">
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
                        <button class="btn badge m-1 rounded-pill border btn-success" type="button" value="1">Include</button>
                        <button class="btn badge m-1 rounded-pill border btn-danger" type="button" value="2">Exclude</button>
                        ]</span>
                    </p>
                    <div class="row mb-3 pb-1 w-100 border-bottom flex-wrap">
                        <button class="btn btn-sm w-auto m-1 rounded-pill border iei-btn" type="button" value="0">4-koma</button>
                        <button class="btn btn-sm w-auto m-1 rounded-pill border iei-btn" type="button" value="0">Adventure</button>
                        <button class="btn btn-sm w-auto m-1 rounded-pill border iei-btn" type="button" value="0">Fantasy</button>
                        <button class="btn btn-sm w-auto m-1 rounded-pill border iei-btn" type="button" value="0">Si-Fi</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end search box filters --}}
        {{-- result area --}}
        <div class="row mb-3 shadow-sm rounded-2 bg-body-tertiary">
            <p class="text-center">data table area</p>
        </div>
        {{-- end result area --}}
    </div>
@endsection
