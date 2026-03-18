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
                    return `<button type="button" class="btn btn-sm btn-info">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>`;
            }},
            {data: 'category_remarks', name:'category_remarks', searchable: false, visible: false},
        ]
    });
});
