<nav class="navbar navbar-expand bg-body-secondary shadow-sm align-content-between">
    <div class="row align-content-between mx-3 w-100">
        <div class="col-6">
            <ul class="nav navbar-nav nav-pills">
                <li class="nav-item mx-1 px-1">
                    <a class="nav-link {{ request()->routeIs('dashboard-main') ? 'active' : '' }}"
                        href="{{ route('dashboard-main') }}" aria-current="page">
                        <i class="bi bi-clipboard-data me-1"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mx-1 px-1">
                    <a class="nav-link {{ request()->routeIs('books-main-list') ? 'active' : '' }}"
                        href="{{ route('books-main-list') }}">
                        <i class="bi bi-journals me-1"></i>
                        Books
                    </a>
                </li>
                <li class="nav-item mx-1 px-1">
                    <a class="nav-link disabled" href="#">
                        <i class="bi bi-people-fill me-1"></i>
                        Members
                    </a>
                </li>
                <li class="nav-item mx-1 px-1">
                    <a class="nav-link disabled" href="#">
                        <i class="bi bi-gear me-1"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-6">
            <div class="dropdown open  float-end">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ Auth::user()->getAttribute('name') }}
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <button class="dropdown-item disabled" href="#" title="Function not available">
                        Edit Profile
                    </button>
                    <hr>
                    <button class="dropdown-item text-danger" type="button"
                        onclick="document.getElementById('logoutForm').dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- logout form --}}
    @include('auth.logout-form')
    {{-- end logout form --}}

</nav>
