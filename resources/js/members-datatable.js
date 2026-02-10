import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// Initialize without jQuery
$(document).ready(function () {
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
                data: 'member_id', orderable: false, searchable: false,
                render: function (data) {
                    return `
                        <button role="button" data-action="${window.routes.memberDestroy.replace(':id', data)}"
                            class="btn btn-sm btn-danger" data-id="${data}"
                            onclick="utility.handleDTDeleteRecord('#delete-dt-main-form', '#membersTable', this)"
                        >
                            Delete
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
                data: 'member_nic_type',
                name: 'member_nic_type',
                searchable: true, orderable: true, visible: false
            },
        ]
    });

    // Reload when filters change
    $('#searchBox').on('input', () => { reloadDataTableAjax('#membersTable'); });
    $('#searchBtn').on('click', () => { reloadDataTableAjax('#membersTable'); });
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
