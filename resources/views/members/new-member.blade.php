@extends('layouts.app')

@section('title', 'Add New Member')

@section('content')

    <div class="container my-2  py-2">
        {{-- title section --}}
        <div class="row mb-3 border-bottom">
            <h3>Add New Member</h3>
        </div>
        {{-- end title section --}}
        {{-- form area --}}
        <form>
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
                                <label for="member-nic-type" class="form-label">NIC Type</label>
                                <select class="form-select" name="member-nic-type" id="member-nic-type">
                                    <option value="">NIC</option>
                                    <option value="">Driving Permit</option>
                                    <option value="">Post ID</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="nic-number" class="form-label">NIC Number</label>
                                <input type="text" id="nic-number" class="form-control" placeholder="" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="member-dob" class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control" name="member-dob" id="member-dob" />
                    </div>
                </div>
            </div>
            {{-- 2nd row --}}
            <div class="row mx-2 mb-3 bg-body-secondary rounded p-3">
                <div class="mb-3">
                    <label for="member-email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="member-email" id="member-email" />
                </div>
                <div class="mb-3">
                    <label for="member-tel" class="form-label">Telephone / Mobile</label>
                    <input type="tel" class="form-control" name="member-tel" id="member-tel" />
                </div>
                <div class="mb-3">
                    <label for="member-address" class="form-label">Address</label>
                    <textarea class="form-control" name="member-address" id="member-address" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="member-remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" name="member-remarks" id="member-remarks" rows="3"></textarea>
                </div>
                <div class="my-3">
                    <button class="btn btn-danger me-2" type="reset">
                        Clear
                    </button>
                    <button class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
        {{-- end form area --}}
    </div>

@endsection
