@toastifyCss
<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="en">

<head>
    <base href="../../">
    <title>
        Admin Dashboard
    </title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Metronic - Tailwind CSS " name="twitter:title" />
    <meta content="" name="twitter:description" />
    <meta content="{{ asset('adminTemplate') }}/media/app/og-image.png" name="twitter:image" />
    <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Metronic - Tailwind CSS " property="og:title" />
    <meta content="" property="og:description" />
    <meta content="{{ asset('adminTemplate') }}/media/app/og-image.png" property="og:image" />
    <link href="{{ asset('adminTemplate') }}/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="{{ asset('images/logo.png') }}" rel="icon" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('adminTemplate') }}/vendors/apexcharts/apexcharts.css" rel="stylesheet" />
    <link href="{{ asset('adminTemplate') }}/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
    <link href="{{ asset('adminTemplate') }}/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    @yield('style')
</head>

<body
    class="antialiased flex h-full text-base text-gray-700 [--tw-page-bg:#fefefe] [--tw-page-bg-dark:var(--tw-coal-500)] demo1 sidebar-fixed header-fixed bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]">
    @include('inc.message')
    @include('sweetalert2::index')
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;
        if (document.documentElement) {
            if (localStorage.getItem('theme')) {
                themeMode = localStorage.getItem('theme');
            } else if (document.documentElement.hasAttribute('data-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <div class="flex grow">
        <!-- Sidebar -->
        <div class="sidebar dark:bg-coal-600 bg-light border-e border-e-gray-200 dark:border-e-coal-100 fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0"
            data-drawer="true" data-drawer-class="drawer drawer-start top-0 bottom-0" data-drawer-enable="true|lg:false"
            id="sidebar">
            <div class="sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0"
                id="sidebar_header">
                <a class="dark:hidden overflow-hidden" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <button
                    class="btn btn-icon btn-icon-md size-[30px] rounded-lg border border-gray-200 dark:border-gray-300 bg-light text-gray-500 hover:text-gray-700 toggle absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
                    data-toggle="body" data-toggle-class="sidebar-collapse" id="sidebar_toggle">
                    <i
                        class="ki-filled ki-black-left-line toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:toggle-active:rotate-0">
                    </i>
                </button>
            </div>
            <hr>
            <div class="sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
                <div class="scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3" data-scrollable="true"
                    data-scrollable-dependencies="#sidebar_header" data-scrollable-height="auto"
                    data-scrollable-offset="0px" data-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
                    <!-- Sidebar Menu -->
                    <div class="menu flex flex-col grow gap-0.5" data-menu="true" data-menu-accordion-expand-all="false"
                        id="sidebar_menu">
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('information.edit') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                                    App Information
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('adminProducts.index') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary active">
                                    Products
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('categories.index') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary active">
                                    Categories
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('colors.index') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                                    Colors
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('adminOrders.index') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                                    Orders
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('messages.index') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                                    Messages
                                </a>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]"
                                tabindex="0">
                                <a href="{{ route('admins.index') }}"
                                    class="menu-title text-sm font-medium text-gray-800 menu-item-active:text-primary menu-link-hover:!text-primary">
                                    Admins
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End of Sidebar Menu -->
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->
        <!-- Wrapper -->
        <div class="wrapper flex grow flex-col">
            <div class="container-fixed">
                <header
                    class="header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]"
                    data-sticky="true" data-sticky-class="shadow-sm" data-sticky-name="header" id="header">
                    <!-- Container -->
                    <div class="container-fixed flex justify-between items-stretch lg:gap-4" id="header_container">
                        <!-- Mobile Logo -->
                        <div class="flex gap-1 lg:hidden items-center -ms-1">
                            <div class="flex items-center">
                                <button class="btn btn-icon btn-light btn-clear btn-sm" data-drawer-toggle="#sidebar">
                                    <i class="ki-filled ki-menu">
                                    </i>
                                </button>
                            </div>
                        </div>
                        <!-- End of Mobile Logo -->
                        <!-- Breadcrumbs -->
                        <div class="flex [.header_&]:below-lg:hidden items-center gap-1.25 text-xs lg:text-sm font-medium mb-2.5 lg:mb-0"
                            data-reparent="true" data-reparent-mode="prepend|lg:prepend"
                            data-reparent-target="#content_container|lg:#header_container">
                            @yield('url_pages')
                        </div>

                        <!-- End of Breadcrumbs -->
                        <!-- Topbar -->
                        <div class="flex items-center gap-2 lg:gap-3.5">
                            <div class="dropdown" data-dropdown="true" data-dropdown-offset="70px, 10px"
                                data-dropdown-offset-rtl="-70px, 10px" data-dropdown-placement="bottom-end"
                                data-dropdown-placement-rtl="bottom-start" data-dropdown-trigger="click|lg:click">
                                <button
                                    class="dropdown-toggle btn btn-icon btn-icon-lg relative cursor-pointer size-9 rounded-full hover:bg-primary-light hover:text-primary dropdown-open:bg-primary-light dropdown-open:text-primary text-gray-500">
                                    {{ auth()->guard('admin')->user()->name }}
                                </button>
                                <div class="dropdown-content light:border-gray-300 w-full max-w-[200px] p-2.5 pb-0">
                                    <div class="flex flex-col h-fit">
                                        <form class="grid grid-cols-12" id="notifications_all_footer" method="POST"
                                            action="{{ route('logout') }}">
                                            @csrf
                                            <button class="btn btn-sm btn-light justify-center">
                                                <i class="ki-filled ki-exit-right"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Topbar -->
                    </div>
                    <!-- End of Container -->
                </header>
                <main class="grow content pt-5 pb-5" id="content" role="content">
                    @yield('content')
                </main>
            </div>
        </div>
        <!-- End of Wrapper -->
    </div>

    @include('inc.loader')
    <!-- End of Page -->
    <!-- Scripts -->
    <script src="{{ asset('adminTemplate') }}/js/core.bundle.js"></script>
    <script src="{{ asset('adminTemplate') }}/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('adminTemplate') }}/js/widgets/general.js"></script>
    <script src="{{ asset('adminTemplate') }}/js/layouts/demo1.js"></script>
    @yield('script')
    <!-- End of Scripts -->
</body>

</html>
@toastifyJs
