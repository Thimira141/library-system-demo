import{j as a}from"./responsive.bootstrap5-C1HQbmS-.js";a(document).ready(function(){a("#categories-manage-categories-main-table").DataTable({processing:!0,serverSide:!0,searching:!0,ajax:window.routes.categoriesAjax,columns:[{data:"category_name",name:"category_name"},{data:"books_count",name:"books_count",className:"text-center"},{data:"id",orderable:!1,searchable:!1,render:function(e){return`
                        <a href="${window.routes.categoryEditView.replace(":id",e)}"
                            class="btn btn-sm btn-info"
                        >Edit</a>
                        <button type="button"
                            class="btn btn-sm btn-danger"
                            data-id="${e}"
                            data-action="${window.routes.categoryDestroySubmit.replace(":id",e)}"
                            onclick="utility.handleDTDeleteRecord('#categories-delete-dt-main-form', '#categories-manage-categories-main-table', this)"
                            data-confirm-message="Are you sure you want to delete this category?">Delete
                        </button>`}},{data:"category_remarks",name:"category_remarks",searchable:!1,visible:!1}]})});
