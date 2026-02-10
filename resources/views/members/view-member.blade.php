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
                <a class="btn btn-primary rounded-pill" href="{{ route('members-edit-member', $member->member_id) }}">
                    <i class="bi bi-pencil-square me-md-1 me-0"></i>
                    <span class="d-md-inline d-none">Edit</span>
                </a>
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
                {{-- form area --}}
                {{-- 1st row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    {{-- cover image  --}}
                    <div class="col-lg-2 col-md-3 col-sm-12 p-2 bg-gradient rounded-4 d-flex align-items-center">
                        <div class="w-100 h-auto position-relative cover-image-action-btn-hover-cover">
                            <img src="{{ Storage::url($member->member_cover_img) }}" class="img-fluid rounded-top w-100"
                                alt="" onerror="this.src='{{ asset('images/placeholder-image-member.svg') }}'" />
                        </div>
                    </div>
                    {{-- end cover image --}}
                    <div class="col  ms-md-3 ms-0 p-2">
                        <div class="mb-3">
                            <label for="member-id" class="form-label pe-none">Member ID</label>
                            <input type="text" id="member-id" class="form-control pe-none" placeholder="Auto Generate"
                                value="{{ $member->member_id }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label for="member-name" class="form-label">Member Name</label>
                            <input type="text" id="member-name" class="form-control pe-none" readonly name="member_name"
                                value="{{ $member->member_name }}" placeholder="" />
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 mb-3">
                                <label for="member-nic-type" class="form-label">NIC Type</label>
                                <select class="form-select" readonly name="member_nic_type" id="member-nic-type">
                                    <option value="NIC" {{ $member->member_nic_type=='NIC' ? 'selected':null }}>NIC</option>
                                    <option value="Driving Permit" {{ $member->member_nic_type=='Driving Permit' ? 'selected':null }}>Driving Permit</option>
                                    <option value="Post ID" {{ $member->member_nic_type=='Post ID' ? 'selected':null }}>Post ID</option>
                                </select>
                            </div>
                            <div class="col mb-3">
                                <label for="member-nic-number" class="form-label">NIC Number</label>
                                <input type="text" id="member-nic-number" readonly name="member_nic_number"
                                    value="{{ $member->member_nic_number }}" class="form-control pe-none" placeholder="" />
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 2nd row --}}
                <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="member-dob" class="form-label">Date Of Birth</label>
                            <input type="date" class="form-control pe-none" readonly name="member_dob"
                                value="{{ $member->member_dob }}" id="member-dob" />
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="member-added" class="form-label">Member Added</label>
                            <input type="date" class="form-control pe-none" readonly name="member_added"
                                value="{{ $member->member_added }}" id="member-added" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="member-email" class="form-label">Email</label>
                        <input type="email" class="form-control pe-none" readonly name="member_email"
                            value="{{ $member->member_email }}" id="member-email" />
                    </div>
                    <div class="mb-3">
                        <label for="member-tel" class="form-label">Telephone / Mobile</label>
                        <input type="tel" class="form-control pe-none" readonly name="member_tel"
                            value="{{ $member->member_tel }}" id="member-tel" />
                    </div>
                    <div class="mb-3">
                        <label for="member-address" class="form-label">Address</label>
                        <textarea class="form-control pe-none" readonly name="member_address" id="member-address" rows="3">{{ $member->member_address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="member-remarks" class="form-label">Remarks</label>
                        <textarea class="form-control pe-none" readonly name="member_remarks" id="member-remarks" rows="3">{{ $member->member_remarks }}</textarea>
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
                                <td class="text-center" colspan="6" scope="row">No Data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- end tab section --}}
    </div>

@endsection
