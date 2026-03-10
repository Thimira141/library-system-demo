import { initTomSelect } from "./tom-select-init";
import { showModal } from "./message_models";
import { partialLoadingAjax } from "./utility-functions";

export function BorrowReturnDashboardInit() {
    // dashboard borrow and return ajax book search
    initTomSelect("#dashboard_borrow_and_return_book", {
        placeholder: "Search book",
        labelField: "book_id",
        valueField: "book_id", searchField: ['book_id', 'book_title'],
        load: (query, callback) => {
            fetch(`/books/ajax/dashboard/books?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(json => { callback(json); })
                .catch(() => { callback(); });
        },
        render: {
            option: (item, escape) => {
                return `<div class="row mb-1">
                <div class="col-2">
                    <img src="/storage/${escape(item.book_cover_img)}" class="img-thumbnail rounded w-100" alt="${escape(item.book_title)}"
                        onerror="this.src='${window.routes.bookImgPlaceholder}'" style="width:80px;height:auto;">
                </div>
                <div class="col">
                    <h5 class="border-bottom">#${escape(item.book_id)}</h5>
                    <h6>${escape(item.book_title)} | ${escape(item.book_author)}</h6>
                </div>
            </div>`;
            }
        },
        onChange: (values) => {
            // load the book
            load_book(values);
            // run the prep-borrow-return
        }
    });
    // dashboard borrow and return ajax member search
    initTomSelect("#dashboard_borrow_and_return_member", {
        placeholder: "Search member",
        labelField: "member_id",
        valueField: "member_id", searchField: ['member_id', 'member_name'],
        load: (query, callback) => {
            fetch(`/members/ajax/dashboard/members?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(json => { callback(json); })
                .catch(() => { callback(); });
        },
        render: {
            option: (item, escape) => {
                return `<div class="row mb-1">
                <div class="col-2">
                    <img src="/storage/${escape(item.member_cover_img)}" class="img-thumbnail rounded w-100" alt="${escape(item.member_name)}"
                        onerror="this.src='${window.routes.memberImgPlaceholder}'" style="width:80px;height:auto;">
                </div>
                <div class="col">
                    <h5 class="border-bottom">#${escape(item.member_id)}</h5>
                    <h6>${escape(item.member_name)} | ${escape(item.member_email)}</h6>
                </div>
            </div>`;
            }
        },
        onChange: (values) => {
            load_member(values);
            // run the prep-borrow-return
        }
    });
}

// function load member/book
async function load_book(book_id) {
    const response = await load_data(`/books/ajax/dashboard/book/${encodeURIComponent(book_id)}`, '#dashboard-bnr-book-data-render');
    const bookElement = document.querySelector('#dashboard-bnr-book-data-render');
    bookElement.querySelector('img.cover-img').setAttribute('src', '/storage/'+response.book.book_cover_img);
    bookElement.querySelector('.book-id').textContent = "#"+response.book.book_id;
    bookElement.querySelector('.book-title').textContent = response.book.book_title;
    bookElement.querySelector('.book-author').textContent = response.book.book_author;
    bookElement.querySelector('.book-summary').textContent = response.book.book_remarks;
}
async function load_member(member_id) {
    const response = await load_data(`/members/ajax/dashboard/member/${encodeURIComponent(member_id)}`, '#dashboard-bnr-member-data-render');
    const memberElement = document.querySelector('#dashboard-bnr-member-data-render');
    memberElement.querySelector('img.cover-img').setAttribute('src', '/storage/'+response.member.member_cover_img);
    memberElement.querySelector('.member-id').textContent = "#"+response.member.member_id;
    memberElement.querySelector('.member-name').textContent = response.member.member_name;
    memberElement.querySelector('.member-email').textContent = response.member.member_email;
}

async function load_data(url, loader) {
    partialLoadingAjax(loader, false); // show loader
    try {
        const response = await fetch(url);

        if (!response.ok) {
            // show error modal with status text
            showModal('error', response.statusText);
            return null; // stop here if error
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error:', error);
        showModal('error', error.message);
        return null;
    } finally {
        // always hide loader, success or error
        partialLoadingAjax(loader, true);
    }
}


// function prep-borrow-return
function prep_borrow_return(book_id, member_id) {
    // check both book/member is set
    // submit data to server
    // retrieve and set form field
}

