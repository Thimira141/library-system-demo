@extends('layouts.app')

@section('title', 'Manage Book Categories')

@section('content')
    <div class="container my-2  py-2">
        <div class="row my-3 border-bottom">
            <div class="col">
                <h4>Manage Book Categories</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('categories-new-view') }}" class="btn btn-sm btn-primary">New Category</a>
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
                            {{-- <tr class="">
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
                            </tr> --}}
                        </tbody>
                    </table>
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
    <script>
        window.routes = {
            categoriesAjax: @json(route('categories-search-dt-ajax')),
            categoryEditView: @json(route('categories-edit-view', ':id')),
            categoryDestroySubmit: @json(route('categories-delete-category', ':id')),
        };
    </script>

@endsection
