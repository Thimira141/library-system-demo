@extends('layouts.app')

@section('title', 'Manage Book Categories')

@section('content')
    <div class="container my-2  py-2">
        <div class="row my-3 border-bottom">
            <div class="col">
                <h4>Manage Book Categories</h4>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-sm btn-primary">New Category</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover" id="categories-manage-categories-main-table">
                        <thead>
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col">Used</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td scope="row">R1C1</td>
                                <td>R1C2</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr class="">
                                <td scope="row">Item</td>
                                <td>Item</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- model to edit category --}}
    <!-- Modal trigger button -->
    <div class="modal fade" id="manage-category-model" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <form method="POST" id="categories-manage-category-submit-form" action="" class="ajax-form"></form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Manage Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-none">
                        <input type="hidden" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" id="category_name"
                            placeholder="Category name" />
                    </div>
                    <div class="mb-3">
                        <label for="category_remarks" class="form-label">Category Remarks</label>
                        <textarea class="form-control" name="category_remarks" id="category_remarks"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- delete form --}}
    <div class="visually-hidden">
        <form action="" method="POST" id="categories-delete-dt-main-form" class="ajax-form" data-confirm="true"
            data-confirm-message="Are you sure you want to Delete this category?">
            @csrf
            @method('DELETE')
            <input type="hidden" id="table-selector" name="id" value="">
        </form>
    </div>

    <!-- Optional: Place to the bottom of scripts -->
    {{-- <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("manage-category-model"),
            options,
        );
    </script> --}}
    <script>
        window.routes = {
            categoriesAjax: @json(route('categories-search-dt-ajax')),
            // categoryNewSubmit: @json(route('books-edit-book', ':id')),
            // categoryEditSubmit: @json(route('books-edit-book', ':id')),
            // categoryDestroySubmit: @json(route('books-delete-book', ':id')),
        };
    </script>

@endsection
