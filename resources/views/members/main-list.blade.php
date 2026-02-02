@extends('layouts.app')

@section('title', 'Members List')

@section('content')
    <div class="container my-2  py-2">
        {{-- search box --}}
        <div class="row mb-3 p-3 shadow-sm rounded-2 bg-body-tertiary">
            <div class="col-md col-sm-12">
                <div class="input-group input-group-lg bg-body">
                    <input type="text" class="form-control" placeholder="Member name, NIC, MemberID...">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                        data-bs-target="#contentId" aria-expanded="false" aria-controls="contentId">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button">
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
        <div class="row mb-3 shadow-sm rounded-2 bg-body-tertiary">
            <p class="text-center">data table area</p>
        </div>
        {{-- end result area --}}
    </div>
@endsection
