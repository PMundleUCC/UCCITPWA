@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <h2>Contact Us</h2>
    <p>Get in touch with UCC or the Information Technology department.</p>

    {{-- Campus contact details and department email. --}}
    <div class="ucc-content-grid">
        <section class="ucc-content-card">
            <h3>Main Campus</h3>
            <p>{{ config('department.university') }}</p>
            <p>{{ config('department.address') }}</p>
            <p><strong>Telephone:</strong> <a href="tel:{{ config('department.dial') }}">{{ config('department.phone') }}</a></p>
            <a href="{{ config('department.website') }}" target="_blank" rel="noopener noreferrer">Visit the UCC website</a>
        </section>

        <section class="ucc-content-card">
            <h3>Information Technology Department</h3>
            <p>Contact the Head of Department for questions about your IT studies.</p>
            <p><a href="mailto:{{ config('department.hod_email') }}">{{ config('department.hod_email') }}</a></p>
            <a class="ucc-action-button" href="mailto:{{ config('department.hod_email') }}?subject=IT%20Department%20Enquiry">Send an email</a>
        </section>

        {{-- Links to further help. --}}
        <section class="ucc-content-card">
            <h3>Faculty &amp; Staff</h3>
            <p>Find contact details for the Dean and IT programme officers.</p>
            <a href="{{ route('directory') }}">View the staff directory</a>
        </section>

        <section class="ucc-content-card">
            <h3>Admissions</h3>
            <p>Read the entry requirements and find out how to apply to UCC.</p>
            <a href="{{ route('admissions') }}">View admission information</a>
        </section>
    </div>
@endsection
