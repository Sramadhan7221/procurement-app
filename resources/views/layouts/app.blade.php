<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Procurement')</title>
    @include('partials.head')
    @stack('styles')
    <style>
        [x-cloak] { display: none !important; }
        /* Reset small */
        *{
            box-sizing:border-box;
            margin:0;
            padding:0
        }
        html,body{
            height:100%
        }

        /* Fullscreen overlay */
        .loader-overlay{
            position:fixed;
            inset:0; /* top:0;right:0;bottom:0;left:0 */
            display:flex;
            align-items:center;
            justify-content:center;
            background:rgba(0,0,0,0.7); /* hitam transparan */
            backdrop-filter: blur(4px);
            z-index:9999;
            transition:opacity .35s ease, visibility .35s ease;
            opacity:1;
            visibility:visible;
        }

        .loader-overlay.hidden{
            opacity:0;
            visibility:hidden;
            pointer-events:none;
        }

        /* Card that holds loader */
        .loader-card{
            width:500px;
            max-width:90%;
            padding:18px 20px;
            border-radius:14px;
            display:flex;
            gap:14px;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            /* background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02)); */
            /* box-shadow:0 6px 30px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.02); */
            color:#fff;
            font-family:Inter,ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;
        }

        /* The animated loader — 3 orbiting dots plus ring */
        .orbital{
            position:relative;
            width:96px;
            height:96px;
        }

        .ring{
            position:absolute;inset:0;border-radius:50%;
            border:3px solid rgba(255,255,255,0.06);
            animation:spin-slow 6s linear infinite;
            box-shadow:0 6px 20px rgba(0,0,0,0.6);
        }

        .dot{
            --size:14px;
            position:absolute;
            width:var(--size);height:var(--size);
            border-radius:50%;
            transform-origin:48px 48px; /* center of orbital */
            top:50%;left:50%;
            margin:-7px 0 0 -7px;
            box-shadow:0 6px 18px rgba(0,0,0,0.6);
        }

        .dot:nth-child(2){
            background:radial-gradient(circle at 30% 30%, #ffd66b, #ff9a3c);
            animation:orbit 1.6s linear infinite; /* fastest */
        }
        .dot:nth-child(3){
            background:radial-gradient(circle at 30% 30%, #7ee7ff, #3ab0ff);
            animation:orbit 2.2s linear infinite;
        }
        .dot:nth-child(4){
            background:radial-gradient(circle at 30% 30%, #c7a3ff, #7a58ff);
            animation:orbit 2.8s linear infinite; /* slowest */
        }

        /* small glow pulse inside */
        .core{
            position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);
            width:18px;height:18px;border-radius:50%;
            background:linear-gradient(135deg,#fff 0%, #ffd66b 50%, #ff9a3c 100%);
            filter:blur(6px);opacity:.18;animation:pulse 1.8s ease-in-out infinite;
        }

        @keyframes orbit{
            0%{
                transform:rotate(0deg) translateX(36px) rotate(0deg)
            }
            100%{
                transform:rotate(360deg) translateX(36px) rotate(-360deg)
            }
        }
        @keyframes spin-slow{
            to{transform:rotate(360deg)}
        }
        @keyframes pulse{
            50%{opacity:.32;transform:scale(1.18)} 
        }

        /* Text */
        .loader-card .message{
            font-size:16px;
            opacity:.95;
            text-align:center;
            line-height:1.1;
            font-weight: bold;
        }

        .subtext{
            font-size:11px;
            color:rgba(255,255,255,0.7);
            opacity:.9
        }

        /* Small responsive tweak */
        @media (max-width:420px){
            .loader-card{
                width:86%;
                padding:14px;
                border-radius:10px
            }
            .orbital{
                width:72px;
                height:72px
            }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    @include('partials.theme-script')

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            @include('partials.header')
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('partials.sidebar')
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!-- Fullscreen loader overlay -->
                    <div id="fullscreen-loader" class="loader-overlay hidden" role="status" aria-live="polite" aria-label="Loading">
                        <div class="loader-card">
                        <div class="orbital" aria-hidden="true">
                            <div class="ring"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="core"></div>
                        </div>
                        <div class="message">Loading data...</div>
                        <div class="subtext">Please check your connection or contact admin for more information.</div>
                        </div>
                    </div>
                    @include('sweetalert::alert')
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')

    @stack('scripts')
</body>
</html>
