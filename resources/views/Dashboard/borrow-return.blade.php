{{-- book / member data input --}}
<div class="row mb-3">
    {{-- book data input --}}
    <div class="col-md-6 col-sm-12">
        {{-- search box --}}
        <div class="row">
            <div class="mb-3">
                <label class="form-label visually-hidden" for="dashboard_borrow_and_return_book">Book</label>
                <select id="dashboard_borrow_and_return_book" class="form-select w-100" placeholder="Book information"
                    aria-label="Book"></select>
            </div>
        </div>
        {{-- end search box --}}
        {{-- filter --}}
        <div class="row mx-2 d-none">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="book-search-filter" id="book-search-filter-id"
                        value="book-search-filter-id" checked />
                    <label class="form-check-label" for="book-search-filter-id"> Filter by ID </label>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="book-search-filter"
                        id="book-search-filter-name" value="book-search-filter-name" />
                    <label class="form-check-label" for="book-search-filter-name"> Filter by Name </label>
                </div>
            </div>
        </div>
        {{-- end filter --}}
    </div>
    {{-- end book data input --}}
    {{-- member data input --}}
    <div class="col-md-6 col-sm-12">
        {{-- search box --}}
        <div class="row">
            <div class="mb-3">
                <label class="form-label visually-hidden" for="dashboard_borrow_and_return_member">Member</label>
                <select id="dashboard_borrow_and_return_member" class="form-select w-100"
                    placeholder="Member information" aria-label="Member"></select>
            </div>
        </div>
        {{-- end search box --}}
        {{-- filter --}}
        <div class="row mx-2 d-none">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="member-search-filter"
                        id="member-search-filter-id" value="member-search-filter-id" checked />
                    <label class="form-check-label" for="member-search-filter-id"> Filter by ID</label>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="member-search-filter"
                        id="member-search-filter-name" value="member-search-filter-name" />
                    <label class="form-check-label" for="member-search-filter-name"> Filter by Name </label>
                </div>
            </div>
        </div>
        {{-- end filter --}}
    </div>
    {{-- end member data input --}}
</div>
{{-- end book / member data input --}}

{{-- book / member data area --}}
<div class="row m-3 justify-content-between mb-3 pt-3 border-top">
    <div class="col-md-4 col-sm-12 ">
        <div class="card mb-3 h-100 w-100 py-1 border-0" style="max-width: 540px;">
            <div class="row g-0 border h-100 p-2 shadow-sm rounded" id="dashboard-bnr-book-data-render">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start w-100 cover-img" alt="cover-image"
                        onerror="this.src='{{ asset('images/placeholder-image-book.svg') }}'">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title book-id">Book ID</h5>
                        <h5 class="card-title book-title">Book Name</h5>
                        <h5 class="card-title book-author">Book Name</h5>
                        <p class="card-text book-summary">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.< book summary>
                        </p>
                        <p class="d-none">
                            <button class="btn btn-link">
                                More
                                <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card mb-3 h-100 w-100 py-1 border-0" style="max-width: 540px;">
            <div class="row g-0 border h-100 px-2 shadow-sm rounded" id="dashboard-bnr-member-data-render">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start w-100 cover-img" alt="cover-image"
                        onerror="this.src='{{ asset('images/placeholder-image-member.svg') }}'">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title member-name">Member Name</h5>
                        <h5 class="card-title member-id">#memberID</h5>
                        <h5 class="card-title member-email">member email</h5>
                        <p class="d-none">
                            <button class="btn btn-link">
                                More
                                <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 py-1">
        <div class="p-2 h-100 w-100 border shadow-sm rounded">
            <div class="mb-3">
                <label for="borrowed_date" class="form-label">Borrowed Date</label>
                <input type="date" class="form-control" name="borrowed_date" id="borrowed_date" />
            </div>
            <div class="mb-3">
                <label for="return_promised_date" class="form-label">Return Date</label>
                <input type="date" class="form-control" name="return_promised_date" id="return_promised_date" />
            </div>
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea name="" id="" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                {{-- <label class="form-label">Return Date</label> --}}
                <p>12 days late | from 12</p>
            </div>
        </div>
    </div>
</div>
{{-- end book / member data area --}}

<div class="row border-top mx-3 py-3">
    <div class="col mb-3 border p-2 rounded shadow-sm">
        <div class="row">
            <p><i class="bi bi-clock-history me-1"></i>Similar Transactions</p>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">...</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>TR201234-FDF</td>
                            <td>Borrowed</td>
                            <td>
                                <button class="btn btn-sm btn-secondary">
                                    <i class="bi bi-arrow-up-right-square"></i>
                                    <span class="d-none d-md-inline ">Open</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="">
                            <td>TR201154-FDF</td>
                            <td>Returned</td>
                            <td>
                                <button class="btn btn-sm btn-secondary">
                                    <i class="bi bi-arrow-up-right-square"></i>
                                    <span class="d-none d-md-inline ">Open</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 mb-3">
        {{-- action buttons --}}
        <div class="row flex-column justify-content-center align-items-center mx-2 h-100 w-100">
            <div class="col-12">
                <button class="btn btn-lg btn-primary mt-3 mx-sm-1 mx-md-2 w-100">
                    <i class="bi bi-journal-arrow-up me-1"></i>
                    Book Borrow
                </button>
            </div>
            <div class="col-12">
                <button class="btn btn-lg btn-success mt-3 mx-sm-1 mx-md-2 w-100">
                    <i class="bi bi-journal-arrow-down me-1"></i>
                    Book Return
                </button>
            </div>
            <div class="col-12">
                <button class="btn btn-lg btn-info mt-3 mx-sm-1 mx-md-2 w-100">
                    <i class="bi bi-calendar2-plus"></i>
                    Extend Period
                </button>
            </div>
        </div>
        {{-- end action buttons --}}
    </div>
</div>
<script>
    window.routes = {
        memberImgPlaceholder: @json(asset('images/placeholder-image-member.svg')),
        bookImgPlaceholder: @json(asset('images/placeholder-image-book.svg'))
    };
</script>
