<div class="sidebar d-flex flex-column p-3">

    <h3 class="mb-4 ps-2 fw-bold">
        <i class="fa-solid fa-wallet me-2"></i> AccoSys
    </h3>

    <nav class="nav flex-column">

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}"
            class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house me-2"></i> Dashboard
        </a>

        <!-- INCOME -->
        <a href="{{ route('income.index') }}"
            class="nav-link text-white {{ request()->routeIs('income') ? 'active' : '' }}">
            <i class="fa-solid fa-money-bill-trend-up me-2"></i> Incomes
        </a>


        <a href="{{ route('expense-types.index') }}"
            class="nav-link text-white {{ request()->routeIs('expense-types.index') ? 'active' : '' }}">
            <i class="fa-solid fa-tags me-2"></i> Expense Types
        </a>

        <a href="{{ route('expense-categories.index') }}"
            class="nav-link text-white {{ request()->routeIs('expense-categories.index') ? 'active' : '' }}">
            <i class="fa-solid fa-list me-2"></i> Expense Categories
        </a>

        <a href="{{ route('outcomes.index') }}"
            class="nav-link text-white {{ request()->routeIs('outcomes.*') ? 'active' : '' }}">
            <i class="fa-solid fa-money-bill-transfer me-2"></i> Outcomes ++
        </a>

        <a href="{{ route('outcome-report.index') }}"
            class="nav-link text-white {{ request()->routeIs('outcome-report.index') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line me-2"></i> Outcome Report
        </a>

        <a href="{{ route('approval.history') }}"
            class="nav-link text-white {{ request()->routeIs('approval.history') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left me-2"></i> Approval History
        </a> {{-- not working --}}

        <a href="{{ route('category.summary') }}"
            class="nav-link text-white {{ request()->routeIs('category.summary') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group me-2"></i> Summary of Outcome
        </a> {{-- not working --}}

        <hr class="text-white-50">

        <!-- EMPLOYEE -->
        <a href="{{ route('employees.index') }}"
            class="nav-link text-white {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users me-2"></i> Employees
        </a>

        <a href="{{ route('donators.index') }}"
            class="nav-link text-white {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="fa-solid fa-hand-holding-dollar me-2"></i> Donators
        </a>

        <a href="{{ route('monthly.salary') }}"
            class="nav-link text-white {{ request()->routeIs('monthly.salary') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days me-2"></i> Monthly Salary List
        </a> {{-- not working --}}

        <a href="{{ route('approve.salary') }}"
            class="nav-link text-white {{ request()->routeIs('approve.salary') ? 'active' : '' }}">
            <i class="fa-solid fa-check-double me-2"></i> Approve Salary List
        </a> {{-- not working --}}

        <a href="{{ route('freelancers') }}"
            class="nav-link text-white {{ request()->routeIs('freelancers') ? 'active' : '' }}">
            <i class="fa-solid fa-laptop-code me-2"></i> Freelancers
        </a> {{-- not working --}}

        <a href="{{ route('social.media') }}"
            class="nav-link text-white {{ request()->routeIs('social.media') ? 'active' : '' }}">
            <i class="fa-solid fa-bullhorn me-2"></i> Social Media
        </a> {{-- not working --}}

        <a href="{{ route('beneficiary') }}"
            class="nav-link text-white {{ request()->routeIs('beneficiary') ? 'active' : '' }}">
            <i class="fa-solid fa-hand-holding-heart me-2"></i> Help / Charity
        </a> {{-- not working --}}

        <hr class="text-white-50">
        <a href="{{ route('users.index') }}"
            class="nav-link text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user me-2"></i> Users
        </a>

        <a href="{{ route('roles.index') }}"
            class="nav-link text-white {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-shield me-2"></i> Roles
        </a>

        <hr class="text-white-50">

        <a href="{{ route('settings') }}"
            class="nav-link text-white {{ request()->routeIs('settings') ? 'active' : '' }}">
            <i class="fa-solid fa-gear me-2"></i> Settings
        </a> {{-- not working --}}

        <div class="mt-3">
            <a href="{{ route('outcome.receipt') }}" class="btn btn-sm btn-light w-100">
                <i class="fa-solid fa-print"></i> Print Receipt
            </a>
        </div>

    </nav>
</div>
