import { initTomSelect } from "./tom-select-init";
import { showModal } from "./message_models";
import { partialLoadingAjax } from "./utility-functions";

export function BorrowReturnDashboardInit() {
    window.BBR_book_id = null;
    window.BBR_member_id = null;
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
            window.BBR_book_id = values;
            prep_borrow_return();
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
            window.BBR_member_id = values;
            prep_borrow_return();
        }
    });
    // set form submit buttons actions
    document.querySelectorAll('#bbr-book-borrow-button, #bbr-book-return-button').forEach(e => {
        e.addEventListener('click', () => {
            const bbrForm = document.querySelector('form#bbr-form');
            if (!bbrForm) return;

            // Use requestSubmit so submit event listeners (like AJAX submit) run
            if (typeof bbrForm.requestSubmit === 'function') {
                bbrForm.requestSubmit();
            } else {
                bbrForm.dispatchEvent(new Event('submit', { cancelable: true }));
                // reload ui
                // bbrForm.addEventListener('ajax:success', prep_borrow_return());
            }
        });
    })
}

// function load member/book
async function load_book(book_id) {
    const response = await load_data(`/books/ajax/dashboard/book/${encodeURIComponent(book_id)}`, '#dashboard-bnr-book-data-render');
    const bookElement = document.querySelector('#dashboard-bnr-book-data-render');
    bookElement.querySelector('img.cover-img').setAttribute('src', '/storage/' + response.book.book_cover_img);
    bookElement.querySelector('.book-id').textContent = "#" + response.book.book_id;
    bookElement.querySelector('.book-title').textContent = response.book.book_title;
    bookElement.querySelector('.book-author').textContent = response.book.book_author;
    bookElement.querySelector('.book-summary').textContent = response.book.book_remarks;
}
async function load_member(member_id) {
    const response = await load_data(`/members/ajax/dashboard/member/${encodeURIComponent(member_id)}`, '#dashboard-bnr-member-data-render');
    const memberElement = document.querySelector('#dashboard-bnr-member-data-render');
    memberElement.querySelector('img.cover-img').setAttribute('src', '/storage/' + response.member.member_cover_img);
    memberElement.querySelector('.member-id').textContent = "#" + response.member.member_id;
    memberElement.querySelector('.member-name').textContent = response.member.member_name;
    memberElement.querySelector('.member-email').textContent = response.member.member_email;
}

async function load_data(url, loader = null) {
    loader && partialLoadingAjax(loader, false); // show loader
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
        loader && partialLoadingAjax(loader, true);
    }
}


// function prep-borrow-return
async function prep_borrow_return() {
    // reset form
    resetBBRForm();
    // check both book/member is set
    if (!window.BBR_book_id || !window.BBR_member_id) { return false };
    // set book_id,member_id to bbr-form
    const bbrForm = document.querySelector('form#bbr-form') || null;
    if (!bbrForm) {
        showModal('error', 'Main Form Cant Find');
        return false;
    }
    // set form fields
    bbrForm.querySelector('input[name="book_id"]').value = window.BBR_book_id;
    bbrForm.querySelector('input[name="member_id"]').value = window.BBR_member_id;
    // disable buttons // note: think about disabling form ares not just the buttons
    document.querySelectorAll('#bbr-book-borrow-button, #bbr-book-return-button'/*, #bbr-book-extend-button'*/).forEach(e => {
        e.classList.add('disabled', 'pe-none')
    });
    // submit data to server
    let url = window.routes.bbrCheckBBRPrep + `?book_id=${window.BBR_book_id}&member_id=${window.BBR_member_id}`;
    const response = await load_data(url, '.bbr-check-bbr-prep');
    console.log(response); // console log
    if (response.status == 'success') {
        // set form fields ready
        if (response.record) {
            // this is a return/extend action
            showModal('success', response.message);
            // set form action
            bbrForm.setAttribute('action', window.routes.bbrFormSubmitBookReturn);
            // fill form fields
            for (const [field, value] of Object.entries(response.record)) {
                bbrForm.querySelector(`input[name="${field}"]`)?.value('value', value);
            }
            // enable book return/extend button
            document.querySelectorAll('#bbr-book-return-button'/*, #bbr-book-extend-button'*/).forEach(e => {
                e.classList.remove('disabled', 'pe-none')
            });
            // enable fields
            bbrForm.querySelectorAll('input[name="returned_date"], textarea').forEach(e => {
                e.classList.remove('disabled', 'pe-none')
            });
            // book status
            const [year, month, day] = response.record.return_promised_date.split("-").map(Number);
            const parsedDate = new Date(year, month - 1, day); // midnight local time

            // Today's date at midnight
            const today = new Date();
            const todayOnly = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            // prepare info
            let bookStatusProp;
            if (parsedDate <= todayOnly) {
                const diffMs = todayOnly - parsedDate;
                let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                diffDays = diffDays > 0 ? diffDays : 0;
                bookStatusProp = { class: 'btn-danger', text: `${diffDays} days late!` };
            } else {
                bookStatusProp = { class: 'btn-success', text: 'In time!' };
            }
            // set info
            const bbrStatus = bbrForm.querySelector('div#bbr-status');
            if (bbrStatus) {
                bbrStatus.classList.remove('btn-secondary');
                bbrStatus.classList.add(bookStatusProp.class);
                bbrStatus.textContent = bookStatusProp.text;
            }

        } else {
            // this is a book borrow action
            if (response.can_borrow) {
                bbrForm.setAttribute('action', window.routes.bbrFormSubmitBookBorrow);
                // book can borrow
                showModal('success', response.message);
                // enable book borrow button
                document.querySelector('#bbr-book-borrow-button').classList.remove('pe-none', 'disabled');
                // enable fields
                bbrForm.querySelectorAll('input[name="borrowed_date"], input[name="return_promised_date"], textarea').forEach(e => {
                    e.value = '';
                    e.classList.remove('disabled', 'pe-none');
                });
            } else {
                // book cant be borrow
                showModal('error', response.message);
            }
        }
        // similar transactions table
        const similarTransactionsTableElement = document.querySelector('#bbr-similar_transactions_table tbody') || false;
        if (similarTransactionsTableElement) {
            // wipe <tr> in <tbody>
            similarTransactionsTableElement.innerHTML = '';
            response.similar_transactions.forEach(row => {
                // make tr row
                const tr = document.createElement('tr');
                // fill td cols
                for (const [key, value] of Object.entries(row)) {
                    const td = document.createElement('td');
                    td.textContent = value;
                    td.setAttribute('data-belongs-to', key);
                    tr.appendChild(td);
                }
                // append to tbody
                similarTransactionsTableElement.appendChild(tr);
            });
        }
    }
}

/**
 * reset form#bbr-form and elements associated with it
 */
function resetBBRForm() {
    // get form
    const bbrForm = document.querySelector('form#bbr-form')||false;
    if (!bbrForm) {return false;}
    // reset form
    bbrForm.reset();
    // reset book return status
    const bbrStatus = bbrForm.querySelector('div#bbr-status');
    if (bbrStatus) {
        bbrStatus.classList.remove('btn-success', 'btn-danger');
        bbrStatus.classList.add('btn-secondary');
        bbrStatus.textContent = 'Book Return Status';
    }
    // disable submit buttons
    document.querySelectorAll('#bbr-book-borrow-button, #bbr-book-return-button, #bbr-book-extend-button').forEach(e => {
        e.classList.add('disabled', 'pe-none');
    });
    bbrForm.querySelectorAll('input, textarea').forEach(e=> {e.classList.add('disabled', 'pe-none')});
    // clear bbr-similar_transactions_table -> <tbody>
    const similarTransactionsTableElement = document.querySelector('#bbr-similar_transactions_table tbody') || false;
    if (similarTransactionsTableElement) {similarTransactionsTableElement.innerHTML='';}
}

