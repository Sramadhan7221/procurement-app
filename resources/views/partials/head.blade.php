<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:title" content="Islamic Mind" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@if(session('user_id'))
<meta name="user-id" content="{{ session('user_id') }}">
<meta name="user-role" content="{{ session('role') }}">
@endif
<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" />