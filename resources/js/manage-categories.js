import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

$(document).ready(function () {
    // categories-manage-categories-main-table table
    $('#categories-manage-categories-main-table').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: window.routes.categoriesAjax,
        columns: [
            {data: 'category_name', name:'category_name'},
            {data: 'books_count', name:'books_count', className: 'text-center'},
            {data: 'id', orderable: false, searchable:false,
                render: function(data) {
                    return `
                        <a href="${window.routes.categoryEditView.replace(':id', data)}"
                            class="btn btn-sm btn-info"
                        >Edit</a>
                        <button type="button"
                            class="btn btn-sm btn-danger"
                            data-id="${data}"
                            data-action="${window.routes.categoryDestroySubmit.replace(':id', data)}"
                            onclick="utility.handleDTDeleteRecord('#categories-delete-dt-main-form', '#categories-manage-categories-main-table', this)"
                            data-confirm-message="Are you sure you want to delete this category?">Delete
                        </button>`;
            }},
            {data: 'category_remarks', name:'category_remarks', searchable: false, visible: false},
        ]
    });
});
