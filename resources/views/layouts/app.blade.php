<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Home') - {{ config('department.university') }}</title>
    {{-- PWA settings and compiled styles/scripts. --}}
    @PwaHead
    @vite(['resources/css/ucc-student-hub.css', 'resources/js/ucc-student-hub.js'])
</head>
<body>
    <a class="ucc-skip-link" href="#main">Skip to content</a>

    {{-- Shared header and navigation. --}}
    <header class="ucc-site-header">
        <h1>{{ config('department.university') }}</h1>
        <p>{{ config('department.name') }}</p>
    </header>

    <nav class="ucc-main-menu" aria-label="Main navigation">
        <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a>
        <a href="{{ route('directory') }}" @if(request()->routeIs('directory')) aria-current="page" @endif>Faculty &amp; Staff</a>
        <a href="{{ route('courses.index') }}" @if(request()->routeIs('courses.index')) aria-current="page" @endif>Courses</a>
        <a href="{{ route('admissions') }}" @if(request()->routeIs('admissions')) aria-current="page" @endif>Admissions</a>
        <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact Us</a>
    </nav>

    {{-- Each page supplies its content here. --}}
    <main id="main">
        @yield('content')
    </main>

    {{-- UCC contact details and social links. --}}
    <footer>
        <p>{{ config('department.university') }} - IT Department</p>
        <p>{{ config('department.address') }}</p>
        <p><a href="tel:{{ config('department.dial') }}">{{ config('department.phone') }}</a></p>
        <nav class="ucc-social-links" aria-label="UCC social media">
            @foreach(config('department.social') as $name => $url)
                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $name }}</a>
            @endforeach
        </nav>
    </footer>

    {{-- Email shortcut available on every page. --}}
    <a class="ucc-hod-email-button" href="mailto:{{ config('department.hod_email') }}?subject=IT%20Department%20Enquiry">
        Email HOD
    </a>

    @RegisterServiceWorkerScript
</body>
</html>
