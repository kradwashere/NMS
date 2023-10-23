<template>
    <div>
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <Link href='/' class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/images/logo.png" alt="" height="30" />
                    </span>
                    <span class="logo-lg">
                        <img src="/images/logo-dark.png" alt="" height="17" />
                    </span>
                </Link>
                <Link href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/images/logo.png" alt="" height="30" />
                    </span>
                    <span class="logo-lg">
                        <img src="/images/logo-light.png" alt="" height="17" />
                    </span>
                </Link>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover" @click="initActiveMenu">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

             <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Home') }" href="/home">
                        <i class='ri ri-apps-line '></i>
                        <span data-key="t-dashboards">Home</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Trip') }" href="/trips">
                        <i class='ri-ship-2-fill'></i>
                        <span data-key="t-students">Trips</span>
                    </Link>
                </li>  
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Expense') }" href="/expenses">
                        <i class='ri-hand-coin-fill'></i>
                        <span data-key="t-students">Materials and Expenses</span>
                    </Link>
                </li>  
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Loan') }" href="/loans">
                        <i class='ri-safe-2-fill'></i>
                        <span data-key="t-students">Cash Loans</span>
                    </Link>
                </li>  
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Transportation') }" href="/transportations">
                        <i class='ri-ship-line'></i>
                        <span data-key="t-students">Transportations</span>
                    </Link>
                </li>  
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Name') }" href="/names">
                        <i class='ri-book-2-line '></i>
                        <span data-key="t-students">Names</span>
                    </Link>
                </li>  
            </ul>

            <div class="sidebar-background"></div>
        </div>
        <div class="vertical-overlay" id="overlay"></div>
    </div>
</template>