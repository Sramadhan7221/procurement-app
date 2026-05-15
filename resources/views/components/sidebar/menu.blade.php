<!--begin::Menu-->
<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
    <!--begin:Menu item-->
    <div class="menu-item">
        <!--begin:Menu link-->
        <a class="menu-link" id="home" href="{{ route('home') }}">
            <span class="menu-icon">
                <i class="ki-duotone ki-code fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
            </span>
            <span class="menu-title">Dashboard</span>
        </a>
        <!--end:Menu link-->
    </div>
    @if(session('role') == '8f92ec44-9a9c-4410-8847-27fc447ec1a4')
        <!--end:Menu item-->
        <div class="menu-item pt-5">
            <!--begin:Menu content-->
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Master Data</span>
            </div>
            <!--end:Menu content-->
        </div>
        <!--begin:Menu item-->
        <div class="menu-item">
            <a class="menu-link" id="division" href="{{ route('division.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-people fs-1">
                        <span class="path1"></span><span class="path2"></span>
                        <span class="path3"></span><span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </span>
                <span class="menu-title">Division</span>
            </a>
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <a class="menu-link" id="category" href="{{ route('category.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-category fs-1">
                        <span class="path1"></span><span class="path2"></span>
                        <span class="path3"></span><span class="path4"></span>
                    </i>
                </span>
                <span class="menu-title">Category</span>
            </a>
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <a class="menu-link" id="vendor" href="{{ route('vendor.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-truck fs-1">
                        <span class="path1"></span><span class="path2"></span>
                        <span class="path3"></span><span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </span>
                <span class="menu-title">Vendor</span>
            </a>
        </div>
        <!--end:Menu item-->
        <!--begin:Menu item-->
        <div class="menu-item">
            <a class="menu-link" id="product" href="{{ route('product.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-package fs-1">
                        <span class="path1"></span><span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </span>
                <span class="menu-title">Product</span>
            </a>
        </div>
    @endif
    <!--end:Menu item-->
    <div class="menu-item pt-5">
        <!--begin:Menu content-->
        <div class="menu-content">
            <span class="menu-heading fw-bold text-uppercase fs-7">Procurement</span>
        </div>
        <!--end:Menu content-->
    </div>
    @if(session('role') == '7cc64a6b-ce62-4cee-a13a-d8d82786cc1e')
    <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion hover show">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-document fs-1">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </span>
                <span class="menu-title">Procurement Request</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->
            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
                <!--begin:Menu item-->
                <div class="menu-item">
                    <a class="menu-link" id="procurement-request-staff" href="{{ route('procurement-request.staff') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-document fs-1">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Procurement Request Form</span>
                    </a>
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div class="menu-item">
                    <a class="menu-link" id="procurement-list-request-staff" href="{{ route('procurement-list-request.staff') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-some-files fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Procurement Request List</span>
                    </a>
                </div>
                <!--end:Menu item-->
            </div>
            <!--end:Menu sub-->
        </div>
    <!--end:Menu item-->
    @endif
    @if(session('role') == '36dfb5d7-7094-4213-9777-8e91f709a1fb')
    <!--begin:Menu item-->
    <div class="menu-item">
        <a class="menu-link" id="procurement-request-manager" href="{{ route('procurement-request.manager') }}">
            <span class="menu-icon">
                <i class="ki-duotone ki-document fs-1">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </span>
            <span class="menu-title">Procurement Request</span>
        </a>
    </div>
    <!--end:Menu item-->
    @endif
    @if(session('role') == '8f92ec44-9a9c-4410-8847-27fc447ec1a4')
    <!--begin:Menu item-->
    <div class="menu-item">
        <a class="menu-link" id="procurement-request-admin" href="{{ route('procurement-request.admin') }}">
            <span class="menu-icon">
                <i class="ki-duotone ki-document fs-1">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </span>
            <span class="menu-title">Procurement Request</span>
        </a>
    </div>
    <!--end:Menu item-->
    <div class="menu-item pt-5">
        <div class="menu-content">
            <span class="menu-heading fw-bold text-uppercase fs-7">Settings</span>
        </div>
    </div>
    <!--begin:Menu item-->
    <div class="menu-item">
        <a class="menu-link" id="role" href="{{ route('role.index') }}">
            <span class="menu-icon">
                <i class="ki-duotone ki-shield-tick fs-1">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </span>
            <span class="menu-title">Roles</span>
        </a>
    </div>
    <!--end:Menu item-->
    @endif
    
</div>
<!--end::Menu-->
