<div class="top-header">
    <div class="d-flex align-items-center">
        <button class="hamburger-menu" id="hamburgerMenu">
            <i class="fas fa-bars"></i>
        </button>
        <h4>@yield('page-title', 'DASHBOARD')</h4>
    </div>
    <div class="header-actions">
        <div class="header-icon d-none d-sm-block">
            <i class="fas fa-search"></i>
        </div>
        <div class="header-icon d-none d-sm-block">
            <i class="fas fa-bell"></i>
            <span class="badge">3</span>
        </div>
        <div class="header-icon d-none d-sm-block">
            <i class="fas fa-envelope"></i>
            <span class="badge">5</span>
        </div>
        <div class="header-icon">
            <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: white; cursor: pointer;" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</div>

