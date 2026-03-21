{{-- date --}}
<div class="row mb-3 justify-content-around">
    <div class="col-11 text-center p-4 bg-body-secondary">
        <p class="display-3" id="date-time-live-update">
            {{ date("Y-m-d") }}
        </p>
    </div>
</div>
{{-- end date --}}
{{-- books count information --}}
<div class="row mb-3 justify-content-around" id="dashboard-info-cards-holder">
    <div class="col-5 text-center p-4 bg-body-secondary rounded shadow-sm" data-dashboard-info-card="total_books">
        <p class="display-3 fw-bold mb-0 border-bottom" data-info-card-write="total_books">44</p>
        <p class="display-6 text-secondary-emphasis">Total Books</p>
    </div>
    <div class="col-5 text-center p-4 bg-body-secondary rounded shadow-sm" data-dashboard-info-card="books_outside">
        <p class="display-3 fw-bold mb-0 border-bottom" data-info-card-write="books_outside">20</p>
        <p class="display-6 text-secondary-emphasis">Currently Outside</p>
    </div>
</div>
{{-- end books count information --}}
{{-- today returns information --}}
<div class="row mb-3 justify-content-around">
    <div class="col-5 text-center p-4 bg-body-secondary rounded shadow-sm" data-dashboard-info-card="books_total_returns">
        <p class="display-3 fw-bold mb-0 border-bottom" data-info-card-write="books_total_returns">10</p>
        <p class="display-6 text-secondary-emphasis">Today Total Returns</p>
    </div>
    <div class="col-5 text-center p-4 bg-body-secondary rounded shadow-sm" data-dashboard-info-card="books_total_returns_expected">
        <p class="display-3 fw-bold mb-0 border-bottom" data-info-card-write="books_total_returns_expected">12</p>
        <p class="display-6 text-secondary-emphasis">Today Expected Returns</p>
    </div>
</div>
{{-- end today returns information --}}
