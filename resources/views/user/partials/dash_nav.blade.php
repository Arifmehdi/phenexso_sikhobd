@php
    // $navLinkBase = '' for the dashboard (in-page tabs); route('user.dashboard') elsewhere
    $navLinkBase = $navLinkBase ?? '';
    $activeTab   = $activeTab ?? '';
    $hasEnrollments = \App\Models\Enrollment::where('user_id', auth()->id())->exists();
    $isTeacher = auth()->user()->hasRole('instructor') || auth()->user()->role === 'instructor'
        || auth()->user()->hasRole('teacher') || auth()->user()->role === 'teacher';
@endphp
<nav class="dash-nav" id="dashNav">
    <a href="{{ $navLinkBase }}#tab-dashboard" data-tab="tab-dashboard" class="{{ $activeTab == 'dashboard' ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i> <span>{{ __('frontend.dash.nav_dashboard') }}</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-courses" data-tab="tab-courses" class="{{ $activeTab == 'courses' ? 'active' : '' }}">
        <i class="fa-solid fa-graduation-cap"></i> <span>{{ __('frontend.dash.nav_courses') }}</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-orders-inline" data-tab="tab-orders-inline" class="{{ $activeTab == 'order' ? 'active' : '' }}">
        <i class="fa-solid fa-cart-shopping"></i> <span>{{ __('frontend.dash.nav_orders') }}</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-ebooks" data-tab="tab-ebooks" class="{{ $activeTab == 'ebooks' ? 'active' : '' }}">
        <i class="fa-solid fa-book-open"></i> <span>{{ __('frontend.dash.nav_ebooks') }}</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-address" data-tab="tab-address" class="{{ $activeTab == 'address' ? 'active' : '' }}">
        <i class="fa-solid fa-location-dot"></i> <span>{{ __('frontend.dash.nav_address') }}</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-account" data-tab="tab-account" class="{{ $activeTab == 'edit' ? 'active' : '' }}">
        <i class="fa-solid fa-user-gear"></i> <span>{{ __('frontend.dash.nav_profile') }}</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-exams" data-tab="tab-exams" class="{{ $activeTab == 'exams' ? 'active' : '' }}">
        <i class="fa-solid fa-file-pen"></i> <span>{{ __('frontend.dash.nav_exams') }}</span>
    </a>
    @if($isTeacher)
    <div style="padding: 15px 20px 5px; font-size: 11px; font-weight: 800; color: var(--text-soft); text-transform: uppercase; letter-spacing: 1px;">Teacher Area</div>
    <a href="{{ $navLinkBase }}#tab-teacher-questions" data-tab="tab-teacher-questions" class="{{ $activeTab == 'teacher_questions' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-question"></i> <span>Manage Questions</span>
    </a>
    <a href="{{ $navLinkBase }}#tab-teacher-exams" data-tab="tab-teacher-exams" class="{{ $activeTab == 'teacher_exams' ? 'active' : '' }}">
        <i class="fa-solid fa-file-invoice"></i> <span>Manage Exams</span>
    </a>
    @endif
    @if($hasEnrollments)
    <a href="{{ $navLinkBase }}#tab-featured" data-tab="tab-featured" class="{{ $activeTab == 'feature_products' ? 'active' : '' }}">
        <i class="fa-solid fa-star"></i> <span>{{ __('frontend.dash.nav_featured') }}</span>
    </a>
    @endif
    <a href="{{ route('logout') }}" style="color: var(--accent); margin-top: auto;">
        <i class="fa-solid fa-right-from-bracket"></i> <span>{{ __('frontend.dash.nav_logout') }}</span>
    </a>
</nav>
