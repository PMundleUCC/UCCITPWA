@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h2>Welcome to UCC Information Technology</h2>
    <p>Explore the Information Technology department at the University of the Commonwealth Caribbean in Kingston, Jamaica.</p>

    {{-- Main menu cards. --}}
    <div class="ucc-content-grid">
        <a class="ucc-content-card ucc-navigation-card" href="{{ route('directory') }}">
            <h3>Faculty &amp; Staff</h3>
            <p>View staff contact details and get in touch.</p>
        </a>

        <a class="ucc-content-card ucc-navigation-card" href="{{ route('courses.index') }}">
            <h3>Courses</h3>
            <p>Browse course codes, credits, and prerequisites.</p>
        </a>

        <a class="ucc-content-card ucc-navigation-card" href="{{ route('admissions') }}">
            <h3>Admissions</h3>
            <p>Read the entry requirements and apply.</p>
        </a>

        <a class="ucc-content-card ucc-navigation-card" href="{{ route('contact') }}">
            <h3>Contact Us</h3>
            <p>Find our campus address, phone number, and department email.</p>
        </a>

    </div>

    {{-- Install button and browser instructions. --}}
    <section class="ucc-content-card">
        <h3>Install the app</h3>
        <button type="button" data-ucc-install-button>Install student hub</button>
        <p data-ucc-install-help hidden>Use your browser's install menu, or Share &gt; Add to Home Screen on iPhone.</p>
    </section>
@endsection
