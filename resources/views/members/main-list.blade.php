@extends('layouts.app')

@section('title', 'Members List')

@section('content')
    <div class="container my-2  py-2">
        {{-- search box --}}
        <div class="row mb-3 p-3 shadow-sm rounded-2 bg-body-tertiary">
            <div class="col-md col-sm-12">
                <div class="input-group input-group-lg bg-body">
                    <input type="text" class="form-control" placeholder="Member name, NIC, MemberID..." id="searchBox">
                    <button class="btn btn-outline-secondary pe-none disabled" disabled type="button"
                        data-bs-toggle="collapse" data-bs-target="#contentId" aria-expanded="false"
                        aria-controls="contentId">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-auto col-sm-12 mt-3 mt-md-0">
                <a class="btn btn-lg btn-secondary w-100" href="{{ route('members-new-member') }}">
                    <i class="bi bi-person-plus me-1"></i>
                    New Member
                </a>
            </div>
        </div>
        {{-- end search box --}}
        {{-- search box filters --}}
        <div class="row mb-3 bg-body-tertiary rounded shadow-sm">
            <div class="collapse mx-3" id="contentId">
                <div class="py-3">
                </div>
            </div>
        </div>
        {{-- end search box filters --}}
        {{-- result area --}}
        <div class="row mb-3 p-2 shadow-sm rounded-2 bg-body-tertiary">
            <div class="table-responsive">
                <table class="table table-hover" id="membersTable">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Member ID</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr class="">
                            <td scope="row">
                                <div class="d-md-inline-block d-sm-flex">
                                    <img class="img-fluid rounded-circle bg-secondary me-2" style="width: 40px; height: auto"
                                        src="{{ asset('images/placeholder-image-member.svg') }}" alt="">
                                    <span>
                                        name of person
                                    </span>
                                </div>
                            </td>
                            <td>R1C2</td>
                            <td>R1C3</td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>

        </div>
        {{-- end result area --}}
    </div>
    <div class="visually-hidden">
        <form action="" method="POST" id="delete-dt-main-form" class="ajax-form" data-confirm="true"
            data-confirm-message="Are you sure you want to delete this member?">
            @csrf
            @method('DELETE')
            <input type="hidden" id="table-selector" name="member_id" value="">
        </form>
    </div>
    <script>
        window.routes = {
            memberView: @json(route('members-view-member', ':id')),
            memberEdit: @json(route('members-edit-member', ':id')),
            memberDestroy: @json(route('members-delete-member', ':id')),
            memberImgPlaceholder: @json(asset('images/placeholder-image-member.svg')),
        };
    </script>
@endsection
