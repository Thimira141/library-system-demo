import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// Initialize without jQuery
$(document).ready(function () {
    $('#booksTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: '/books/data',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: function (d) {
                d.search = { value: $('#searchBox').val() };
                d.include_categories = getIEIFilters('1');
                d.exclude_categories = getIEIFilters('2');
            }
        },
        columns: [
            {
                data: 'book_cover_img',
                orderable: false, searchable: false,
                render: function (data, type, row) {
                    if (type === 'sort' || type === 'filter') return data;
                    return `<img src="/storage/${data}"
                                alt="${row.book_title}"
                                class="img-thumbnail"
                                style="width:80px;height:auto;">`;
                }
            },
            {
                data: 'book_id',
                name: 'book_id',
                searchable: true
            },
            {
                data: 'book_title',
                name: 'book_title',
                searchable: true
            },
            {
                data: 'book_author',
                name: 'book_author',
                searchable: true
            },
            {
                data: 'categories',
                name: 'categories',
                visible: false
            },
            {
                data: 'book_id', orderable: false, searchable: false,
                render: function (data) {
                    return `<a href="#" class="btn btn-sm btn-danger" data-id="${data}">Delete</a>
                                <a href="#" class="btn btn-sm btn-info">View</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>`;
                }
            }
        ]
    });

    // Reload when filters change
    $('#searchBox').on('input', () => {reloadDataTableAjax('#booksTable');});
    $('#searchBtn').on('click', () => {reloadDataTableAjax('#booksTable');});
    // $('#categoryFilter').on('change', function() {
    //     $('#booksTable').DataTable().ajax.reload();
    // });
});


/**
 * Reloads the DataTable via AJAX.
 * @param {string} selector
 */
function reloadDataTableAjax(selector) {
    // Check if the DataTable is initialized
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().ajax.reload();
    }
}

/**
 *
 * @param {string} iei ignore-exclude-include
 *
 * * ignore -> 0
 * * include -> 1
 * * exclude -> 2
 */
function getIEIFilters(iei='0') {
    const ieiBtns = document.querySelectorAll(`.iei-btn[value="${iei}"]`)
    return Array.from(ieiBtns).map(el => el.getAttribute('data-value'));
}
