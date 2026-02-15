{{-- book / member data input --}}
<div class="row mb-3">
    {{-- book data input --}}
    <div class="col-md-6 col-sm-12">
        {{-- search box --}}
        <div class="row">
            <div class="input-group mb-3">
                <label class="form-label visually-hidden" id="book-data-input">Book</label>
                <input type="text" class="form-control rounded-start-2" placeholder="Book information"
                    id="book-data-input" aria-label="Book">
                <button class="btn btn-outline-secondary text-primary-emphasis" type="button">
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
        </div>
        {{-- end search box --}}
        {{-- filter --}}
        <div class="row mx-2">
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
            <div class="input-group mb-3">
                <label class="form-label visually-hidden" id="member-data-input">Member</label>
                <input type="text" class="form-control rounded-start-2" placeholder="Member information"
                    id="member-data-input" aria-label="member">
                <button class="btn btn-outline-secondary text-primary-emphasis" type="button">
                    <i class="bi bi-arrow-right-short"></i>
                </button>
            </div>
        </div>
        {{-- end search box --}}
        {{-- filter --}}
        <div class="row mx-2">
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

{{-- action buttons --}}
<div class="row mb-3 justify-content-center border-top">
    <div class="col-auto">
        <button class="btn btn-lg btn-primary mt-3 mx-sm-1 mx-md-2">
            <i class="bi bi-journal-arrow-up me-1"></i>
            Book Borrow
        </button>
    </div>
    <div class="col-auto">
        <button class="btn btn-lg btn-success mt-3 mx-sm-1 mx-md-2">
            <i class="bi bi-journal-arrow-down me-1"></i>
            Book Return
        </button>
    </div>
</div>
{{-- end action buttons --}}

{{-- book / member data area --}}
<div class="row m-3 justify-content-between">
    <div class="col-md-4 col-sm-12 ">
        <div class="card mb-3 h-100 w-100 py-1 border-0" style="max-width: 540px;">
            <div class="row g-0 border h-100 p-2 shadow-sm rounded">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start w-100" alt="cover-image"
                        onerror="this.src='{{ asset('images/placeholder-image-book.svg') }}'">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Book Name</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.< book summary>
                        </p>
                        <p class="card-text">
                            <span class="badge bg-primary">Adventure</span>
                            <span class="badge bg-primary">Romance</span>
                            <span class="badge bg-primary">Slice of life</span>
                        </p>
                        <p>
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
            <div class="row g-0 border h-100 px-2 shadow-sm rounded">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start w-100" alt="cover-image"
                        onerror="this.src='{{ asset('images/placeholder-image-member.svg') }}'">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Member Name</h5>
                        <h5 class="card-title">#memberID</h5>
                        <p>
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
                <textarea name="" id=""></textarea>
            </div>
            <div class="mb-3">
                {{-- <label class="form-label">Return Date</label> --}}
                <p>12 days late | from 12</p>
            </div>
        </div>
    </div>
</div>
{{-- end book / member data area --}}
