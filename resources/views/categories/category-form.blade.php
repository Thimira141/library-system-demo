@extends('layouts.app')

@section('title', $pageData['title'])

@section('content')
    <div class="container my-2  py-2">
        {{-- title section --}}
        <div class="row mb-3 border-bottom">
            <h3><x-back-button url="{{ route('categories-main-list') }}"/>{{$pageData['title']}}</h3>
        </div>
        {{-- end title section --}}
        {{-- form area --}}
        <form method="post" class="ajax-form"
            action="{{ $pageData['edit'] ? route('categories-edit-category-submit', $category->id) : route('categories-new-category-submit') }}">
            @csrf
            @method('POST')
            <div class="d-none">
                <input type="hidden" name="id" value="{{ $pageData['edit'] ? $category->id : null}}">
            </div>
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="category_name" id="category_name" value="{{ $pageData['edit'] ? $category->category_name : null }}"
                    placeholder="Category name" />
            </div>
            <div class="mb-3">
                <label for="category_remarks" class="form-label">Category Remarks</label>
                <textarea class="form-control" name="category_remarks" id="category_remarks">{{ $pageData['edit'] ? $category->category_remarks : null }}</textarea>
            </div>
            <div class="my-3">
                <button class="btn btn-danger me-2" type="reset">
                    Clear
                </button>
                <button class="btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection
