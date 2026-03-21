import{j as a}from"./responsive.bootstrap5-C1HQbmS-.js";a(document).ready(function(){a("#membersTable").DataTable({processing:!0,serverSide:!0,searching:!1,ajax:{url:"/members/data",type:"POST",headers:{"X-CSRF-TOKEN":a('meta[name="csrf-token"]').attr("content")},data:function(e){e.search={value:a("#searchBox").val()}}},columns:[{data:"member_name",orderable:!0,searchable:!0,render:function(e,r,t){return r==="sort"||r==="filter"?e:`<div class="d-md-inline-block d-sm-flex">
                                <img class="img-fluid rounded-circle bg-secondary me-2" style="width: 50px; height: 50px"
                                    src="/storage/${t.member_cover_img}" alt=""
                                    onerror="this.src='${window.routes.memberImgPlaceholder}'">
                                <span>${e}</span>
                            </div>`}},{data:"member_id",name:"member_id",searchable:!0},{data:"member_nic_number",name:"member_nic_number",searchable:!0,render:(e,r,t)=>r==="sort"||r==="filter"?e:`${t.member_nic_type} / ${e}`},{data:"member_id",orderable:!1,searchable:!1,render:function(e,r,t,i){var n=t.is_deleted,s={class:n?"success":"danger",text:n?"Restore":"Delete"};return`
                        <button role="button"
                            data-action="${window.routes.memberDestroy.replace(":id",e)}"
                            class="btn btn-sm btn-${s.class}"
                            data-id="${e}"
                            onclick="utility.handleDTDeleteRecord('#delete-dt-main-form', '#membersTable', this)"
                            data-confirm-message="Are you sure you want to ${s.text} this member?"
                        >
                            ${s.text}
                        </button>
                        <a href="${window.routes.memberView.replace(":id",e)}" class="btn btn-sm btn-info">View</a>
                        <a href="${window.routes.memberEdit.replace(":id",e)}" class="btn btn-sm btn-warning">Edit</a>
                    `}},{data:"member_cover_img",name:"member_cover_img",searchable:!1,orderable:!1,visible:!1},{data:"is_deleted",name:"is_deleted",searchable:!1,orderable:!1,visible:!1},{data:"member_nic_type",name:"member_nic_type",searchable:!0,orderable:!0,visible:!1}]}),a("#searchBox").on("input",()=>{m("#membersTable")}),a("#searchBtn").on("click",()=>{m("#membersTable")}),a("#members-view-book-borrow-history").DataTable({processing:!0,serverSide:!0,searching:!0,ajax:{url:window.routes.member_books_borrowing_history,type:"GET",headers:{"X-CSRF-TOKEN":a('meta[name="csrf-token"]').attr("content")},data:function(e){e.member_id=a("input#member-id").val()}},columns:[{data:"transaction_id",name:"transaction_id",searchable:!0},{data:"book_id",name:"book_id",searchable:!0},{data:"borrowed_date",name:"borrowed_date",searchable:!1},{data:"return_promised_date",name:"return_promised_date",searchable:!1},{data:"returned_date",name:"returned_date",searchable:!1}]})});function m(e){a.fn.DataTable.isDataTable(e)&&a(e).DataTable().ajax.reload()}
