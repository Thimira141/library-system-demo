import{j as a}from"./jquery.module-gzd0YkcT.js";import"./responsive.bootstrap5-D_HSXjOo.js";import{I as l}from"./utility-functions-JgHOhW6E.js";import{i as d}from"./tom-select-init-Bkzr50fw.js";a(document).ready(function(){l(".iei-btn"),a("#booksTable").DataTable({processing:!0,serverSide:!0,searching:!1,responsive:!0,ajax:{url:"/books/data",type:"POST",headers:{"X-CSRF-TOKEN":a('meta[name="csrf-token"]').attr("content")},data:function(e){e.search={value:a("#searchBox").val()},e.include_categories=n("1"),e.exclude_categories=n("2")}},columns:[{data:"book_title",name:"book_title",render:function(e,o,t){return o==="sort"||o==="filter"?e:`<div class="row">
                                <div class="col-auto">
                                    <img src="/storage/${t.book_cover_img}"
                                        alt="${e}"
                                        class="img-thumbnail"
                                        onerror="this.src='${window.routes.bookImgPlaceholder}'"
                                        style="width:80px;height:auto;">
                                </div>
                                <div class="col">
                                    <p class="text-truncate" style="max-width:250px;">
                                        ${e}
                                    </p>
                                    <p class="truncate-3-lines small" style="max-width:350px;">
                                        ${t.book_summary}
                                    </p>
                                </div>
                            </div>
                        `}},{data:"book_id",name:"book_id",searchable:!1},{data:"book_author",name:"book_author",searchable:!1},{data:"categories",name:"categories",visible:!1},{data:"is_deleted",name:"is_deleted",visible:!1},{data:"book_cover_img",name:"book_cover_img",searchable:!1,visible:!1},{data:"book_id",orderable:!1,searchable:!1,render:function(e,o,t,c){var s=t.is_deleted,r={class:s?"success":"danger",text:s?"Restore":"Delete"};return`
                        <button role="button"
                            data-action="${window.routes.booksDestroy.replace(":id",e)}"
                            class="btn btn-sm btn-${r.class}"
                            data-id="${e}"
                            onclick="utility.handleDTDeleteRecord('#delete-dt-main-form', '#booksTable', this)"
                            data-confirm-message="Are you sure you want to ${r.text} this book?"
                        >
                            ${r.text}
                        </button>
                        <a href="${window.routes.booksView.replace(":id",e)}" class="btn btn-sm btn-info">View</a>
                        <a href="${window.routes.booksEdit.replace(":id",e)}" class="btn btn-sm btn-warning">Edit</a>
                    `}}]}),a("#searchBox").on("input",()=>{i("#booksTable")}),a("#searchBtn").on("click",()=>{i("#booksTable")}),a("#books-view-book-borrow-history").DataTable({processing:!0,serverSide:!0,searching:!0,ajax:{url:window.routes.book_borrowing_history,type:"GET",headers:{"X-CSRF-TOKEN":a('meta[name="csrf-token"]').attr("content")},data:function(e){e.book_id=a("input#book-id").val()}},columns:[{data:"transaction_id",name:"transaction_id",searchable:!0},{data:"member_id",name:"member_id",searchable:!0},{data:"borrowed_date",name:"borrowed_date",searchable:!0},{data:"return_promised_date",name:"return_promised_date",searchable:!0},{data:"returned_date",name:"returned_date",searchable:!0}]}),d("#book_categories",{placeholder:"Select categories",valueField:"id",labelField:"category_name",searchField:"category_name",preload:!0,load:(e,o)=>{fetch(`${window.routes.categoriesAjaxSearch}?q=${encodeURIComponent(e)}`).then(t=>t.json()).then(t=>{o(t)}).catch(()=>{o()})}})});function i(e){a.fn.DataTable.isDataTable(e)&&a(e).DataTable().ajax.reload()}function n(e="0"){const o=document.querySelectorAll(`.iei-btn[value="${e}"]`);return Array.from(o).map(t=>t.getAttribute("data-value"))}
