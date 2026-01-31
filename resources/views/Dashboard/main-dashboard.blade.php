@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row m-3">
        <div class="col">
            <ul class="nav nav-tabs nav-pills mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="main-dashboard-tab" data-bs-toggle="tab"
                        data-bs-target="#main-dashboard-tab-pane" type="button" role="tab"
                        aria-controls="main-dashboard-tab-pane" aria-selected="true">
                        <i class="bi bi-speedometer2 me-1"></i>
                        Dashboard
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="borrow-return-tab" data-bs-toggle="tab"
                        data-bs-target="#borrow-return-tab-pane" type="button" role="tab"
                        aria-controls="borrow-return-tab-pane" aria-selected="false">
                        <i class="bi bi-arrow-left-right me-1"></i>
                        Borrows & Returns
                    </button>
                </li>
            </ul>
            <div class="tab-content p-2" id="myTabContent">
                <div class="tab-pane fade show active" id="main-dashboard-tab-pane" role="tabpanel"
                    aria-labelledby="main-dashboard-tab" tabindex="0">
                    @include('dashboard.dashboard')
                </div>
                <div class="tab-pane fade" id="borrow-return-tab-pane" role="tabpanel" aria-labelledby="borrow-return-tab"
                    tabindex="0">
                    @include('dashboard.borrow-return')
                </div>
            </div>
        </div>
    </div>
@endsection
