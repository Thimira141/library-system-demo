@extends('layouts.app')

@section('title', 'View Member')

@section('content')

    <div class="container my-2  py-2">
        {{-- title section --}}
        <div class="row mb-3 border-bottom justify-content-between">
            <div class="col-auto">
                <h3>View Member</h3>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-pill">
                    <i class="bi bi-pencil-square me-md-1 me-0"></i>
                    <span class="d-md-inline d-none">Edit</span>
                </button>
            </div>
        </div>
        {{-- end title section --}}
        {{-- tab section --}}
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-pills mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="main-member-information-tab" data-bs-toggle="tab"
                    data-bs-target="#main-member-information-tab-pane" type="button" role="tab"
                    aria-controls="main-member-information-tab-pane" aria-selected="true">
                    <i class="bi bi-journal-text me-1"></i>
                    Member Information
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="member-history-tab" data-bs-toggle="tab"
                    data-bs-target="#member-history-tab-pane" type="button" role="tab"
                    aria-controls="member-history-tab-pane" aria-selected="false">
                    <i class="bi bi-clock-history me-1"></i>
                    History
                </button>
            </li>
        </ul>
        <div class="tab-content p-2" id="myTabContent">
            {{-- 1st tab pane --}}
            <div class="tab-pane fade show active" id="main-member-information-tab-pane" role="tabpanel"
                aria-labelledby="main-member-information-tab" tabindex="0">
                {{-- 1st row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    {{-- cover image  --}}
                    <div class="col-lg-2 col-md-3 col-sm-12 p-2 bg-gradient rounded-4 d-flex align-items-center">
                        <div class="w-100 h-auto position-relative">
                            <img src="..." class="img-fluid rounded-top w-100" alt=""
                                onerror="this.src='{{ asset('images/placeholder-image-member.svg') }}'" />
                            <button class="btn btn-secondary position-absolute bottom-0 end-0 rounded-pill"
                                title="Edit Cover Image">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </div>
                    </div>
                    {{-- end cover image --}}
                    <div class="col  ms-md-3 ms-0 p-2">
                        <div class="mb-3">
                            <label for="member-id" class="form-label pe-none">Member ID</label>
                            <input type="text" id="member-id" class="form-control pe-none" placeholder="Auto Generate"
                                value="#AUTO-GENERATE" readonly />
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <label for="member-nic-type" class="form-label pe-none">NIC Type</label>
                                    <select class="form-select pe-none" name="member-nic-type" id="member-nic-type">
                                        <option value="">NIC</option>
                                        <option value="">Driving Permit</option>
                                        <option value="">Post ID</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="nic-number" class="form-label pe-none">NIC Number</label>
                                    <input type="text" id="nic-number" class="form-control pe-none" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="member-dob" class="form-label pe-none">Date Of Birth</label>
                            <input type="date" class="form-control pe-none" name="member-dob" id="member-dob" />
                        </div>
                    </div>
                </div>
                {{-- 2nd row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    <div class="mb-3">
                        <label for="member-email" class="form-label pe-none">Email</label>
                        <input type="email" class="form-control pe-none" name="member-email" id="member-email" />
                    </div>
                    <div class="mb-3">
                        <label for="member-tel" class="form-label pe-none">Telephone / Mobile</label>
                        <input type="tel" class="form-control pe-none" name="member-tel" id="member-tel" />
                    </div>
                    <div class="mb-3">
                        <label for="member-address" class="form-label pe-none">Address</label>
                        <textarea class="form-control pe-none" name="member-address" id="member-address" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="member-remarks" class="form-label pe-none">Remarks</label>
                        <textarea class="form-control pe-none" name="member-remarks" id="member-remarks" rows="3"></textarea>
                    </div>
                </div>
                {{-- end form area --}}
            </div>
            {{-- 2nd tab pane --}}
            <div class="tab-pane fade" id="member-history-tab-pane" role="tabpanel" aria-labelledby="member-history-tab"
                tabindex="0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Book Name</th>
                                <th scope="col">Borrowed Date</th>
                                <th scope="col">Return Promised Date</th>
                                <th scope="col">Returned Date</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td scope="row">R1C1</td>
                                <td>abc def</td>
                                <td>2025-02-02</td>
                                <td>2025-03-01</td>
                                <td>2025-03-04</td>
                                <td>3 days late</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- end tab section --}}
    </div>

@endsection
