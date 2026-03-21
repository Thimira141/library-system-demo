import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// Initialize without jQuery
$(document).ready(function () {
    // members-list main table
    $('#membersTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: '/members/data',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: function (d) {
                d.search = { value: $('#searchBox').val() };
                // d.include_categories = getIEIFilters('1');
                // d.exclude_categories = getIEIFilters('2');
            }
        },
        columns: [
            {
                data: 'member_name',
                orderable: true, searchable: true,
                render: function (data, type, row) {
                    if (type === 'sort' || type === 'filter') return data;
                    return `<div class="d-md-inline-block d-sm-flex">
                                <img class="img-fluid rounded-circle bg-secondary me-2" style="width: 50px; height: 50px"
                                    src="/storage/${row.member_cover_img}" alt=""
                                    onerror="this.src='${window.routes.memberImgPlaceholder}'">
                                <span>${data}</span>
                            </div>`
                }
            },
            {
                data: 'member_id',
                name: 'member_id',
                searchable: true
            },
            {
                data: 'member_nic_number',
                name: 'member_nic_number',
                searchable: true,
                render: (data, type, row) => {
                    if (type === 'sort' || type === 'filter') return data;
                    return `${row.member_nic_type} / ${data}`;
                }
            },
            {
                data: 'member_id',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    var is_deleted = row.is_deleted;
                    var delete_btn_content = {
                        class: is_deleted ? 'success' : 'danger',
                        text: is_deleted ? 'Restore' : 'Delete'
                    };
                    return `
                        <button role="button"
                            data-action="${window.routes.memberDestroy.replace(':id', data)}"
                            class="btn btn-sm btn-${delete_btn_content.class}"
                            data-id="${data}"
                            onclick="utility.handleDTDeleteRecord('#delete-dt-main-form', '#membersTable', this)"
                            data-confirm-message="Are you sure you want to ${delete_btn_content.text} this member?"
                        >
                            ${delete_btn_content.text}
                        </button>
                        <a href="${window.routes.memberView.replace(':id', data)}" class="btn btn-sm btn-info">View</a>
                        <a href="${window.routes.memberEdit.replace(':id', data)}" class="btn btn-sm btn-warning">Edit</a>
                    `;
                }
            },
            {
                data: 'member_cover_img',
                name: 'member_cover_img',
                searchable: false, orderable: false, visible: false
            },
            {
                data: 'is_deleted',
                name: 'is_deleted',
                searchable: false, orderable: false, visible: false
            },
            {
                data: 'member_nic_type',
                name: 'member_nic_type',
                searchable: true, orderable: true, visible: false
            },
        ]
    });

    // Reload when filters change
    $('#searchBox').on('input', () => { reloadDataTableAjax('#membersTable'); });
    $('#searchBtn').on('click', () => { reloadDataTableAjax('#membersTable'); });

    // book borrow history
    $('#members-view-book-borrow-history').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: {
            url: window.routes.member_books_borrowing_history,
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: function (d) {
                d.member_id = $('input#member-id').val()
            }
        },
        columns: [
            {
                data: 'transaction_id',
                name: 'transaction_id',
                searchable: true
            },
            {
                data: 'book_id',
                name: 'book_id',
                searchable: true
            },
            {
                data: 'borrowed_date',
                name: 'borrowed_date',
                searchable: false
            },
            {
                data: 'return_promised_date',
                name: 'return_promised_date',
                searchable: false
            },
            {
                data: 'returned_date',
                name: 'returned_date',
                searchable: false
            }
        ]
    })
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
