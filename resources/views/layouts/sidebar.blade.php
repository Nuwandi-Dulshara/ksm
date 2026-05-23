<div class="sidebar d-flex flex-column p-3" data-dir="{{ app()->getLocale() === 'ar' || app()->getLocale() === 'ku' ? 'rtl' : 'ltr' }}">

    <h3 class="mb-4 ps-2 fw-bold icon-start">
        <i class="fa-solid fa-wallet"></i> AccoSys
    </h3>

    <nav class="nav flex-column">

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}"
            class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i> <span>{{ __('messages.dashboard') }}</span>
        </a>

        <!-- INCOME -->
        <a href="{{ route('income.index') }}"
            class="nav-link text-white {{ request()->routeIs('income') ? 'active' : '' }}">
            <i class="fa-solid fa-money-bill-trend-up"></i> <span>{{ __('messages.incomes') }}</span>
        </a>


        <a href="{{ route('expense-types.index') }}"
            class="nav-link text-white {{ request()->routeIs('expense-types.index') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i> <span>{{ __('messages.expense_types') }}</span>
        </a>

        <a href="{{ route('expense-categories.index') }}"
            class="nav-link text-white {{ request()->routeIs('expense-categories.index') ? 'active' : '' }}">
            <i class="fa-solid fa-list"></i> <span>{{ __('messages.expense_categories') }}</span>
        </a>

        <a href="{{ route('outcomes.index') }}"
            class="nav-link text-white {{ request()->routeIs('outcomes.*') ? 'active' : '' }}">
            <i class="fa-solid fa-money-bill-transfer"></i> <span>{{ __('messages.outcome_plus') }}</span>
        </a>

        <a href="{{ route('outcome-report.index') }}"
            class="nav-link text-white {{ request()->routeIs('outcome-report.index') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i> <span>Outcome Report</span>
        </a>

        <a href="{{ route('money-issuances.index') }}"
            class="nav-link text-white {{ request()->routeIs('money-issuances.*') ? 'active' : '' }}">
            <i class="fa-solid fa-cash"></i> <span>Money Issuances</span>
        </a>

        <a href="{{ route('money-issuances.report') }}"
            class="nav-link text-white {{ request()->routeIs('money-issuances.report') ? 'active' : '' }}">
            <i class="fa-solid fa-file-invoice-dollar"></i> <span>Issuance Reports</span>
        </a>

        <a href="{{ route('approval.history') }}"
            class="nav-link text-white {{ request()->routeIs('approval.history') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i> <span>{{ __('messages.approval_history') }}</span>
        </a>

        <a href="{{ route('category.summary') }}"
            class="nav-link text-white {{ request()->routeIs('category.summary') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> <span>Summary of Outcome</span>
        </a>

        <hr class="text-white-50">

        <!-- EMPLOYEE -->
        <a href="{{ route('employees.index') }}"
            class="nav-link text-white {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users me-2"></i> {{ __('messages.employees') }}
        </a>

        <a href="{{ route('donators.index') }}"
            class="nav-link text-white {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="fa-solid fa-hand-holding-dollar me-2"></i> {{ __('messages.donators') }}
        </a>

        <a href="{{ route('monthly.salary') }}"
            class="nav-link text-white {{ request()->routeIs('monthly.salary') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days me-2"></i> Monthly {{ __('messages.salary') }} List
        </a>

        <a href="{{ route('approve.salary') }}"
            class="nav-link text-white {{ request()->routeIs('approve.salary') ? 'active' : '' }}">
            <i class="fa-solid fa-check-double me-2"></i> Approve {{ __('messages.salary') }} List
        </a>


        <a href="{{ route('freelancers.index') }}"
            class="nav-link text-white {{ request()->routeIs('freelancers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-laptop-code me-2"></i> Freelancers
        </a>

        <a href="{{ route('freelance-categories.index') }}"
            class="nav-link text-white {{ request()->routeIs('freelance-categories.*') ? 'active' : '' }}">
            <i class="fa-solid fa-folder-tree me-2"></i> Freelance Categories
        </a>


        {{-- -this is not working 
        <a href="{{ route('social.media') }}"
        class="nav-link text-white {{ request()->routeIs('social.media') ? 'active' : '' }}">
        <i class="fa-solid fa-bullhorn me-2"></i> Social Media
        </a>
        --}}

        {{-- -this is not working
        <a href="{{ route('beneficiary') }}"
        class="nav-link text-white {{ request()->routeIs('beneficiary') ? 'active' : '' }}">
        <i class="fa-solid fa-hand-holding-heart me-2"></i> Help / Charity
        </a>
        --}}
        <hr class="text-white-50">
        <a href="{{ route('users.index') }}"
            class="nav-link text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user me-2"></i> Users
        </a>

        <a href="{{ route('roles.index') }}"
            class="nav-link text-white {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-shield me-2"></i> {{ __('messages.role') }}s
        </a>

        <hr class="text-white-50">
        {{--  
        <a href="{{ route('settings') }}"
        class="nav-link text-white {{ request()->routeIs('settings') ? 'active' : '' }}">
        <i class="fa-solid fa-gear me-2"></i> Settings
        </a>

        <div class="mt-3">
            <a href="{{ route('outcome.receipt') }}" class="btn btn-sm btn-light w-100">
                <i class="fa-solid fa-print"></i> Print Receipt
            </a>
        </div>
        --}}

    </nav>
</div>
