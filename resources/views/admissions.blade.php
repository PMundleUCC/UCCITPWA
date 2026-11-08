@extends('layouts.app')

@section('title', 'Admissions')

@section('content')
    <h2>Admission Requirements</h2>

    {{-- Undergraduate entry requirements. --}}
    <section class="ucc-content-card">
        <h3>Entry requirements</h3>
        <ul>
            <li>At least five GCE or CSEC subjects, including English Language and Mathematics.</li>
            <li>Accepted grades: GCE A, B or C; CSEC 1, 2 or 3. CSEC Grade 3 must have been obtained from 1998 onward.</li>
            <li>Applicants with four CXC subjects may apply with outstanding subjects or complete UCC replacement courses.</li>
        </ul>
        <p>Mature entry applicants must be at least 25 years old with five years of work experience. Submit academic qualifications, a résumé, a job letter, and three professional references.</p>
        <a href="https://www.ucc.edu.jm/programmes/undergraduate/requirements" target="_blank" rel="noopener noreferrer">UCC admission requirements</a>
    </section>

    {{-- Application steps and official portal. --}}
    <section class="ucc-content-card">
        <h3>How to apply</h3>
        <ol>
            <li>Review the requirements and prepare your documents for upload.</li>
            <li>Complete and submit the UCC undergraduate application.</li>
            <li>Pay the application fee and follow the emailed portal activation instructions.</li>
        </ol>
        <a class="ucc-action-button" href="{{ config('department.application_url') }}" target="_blank" rel="noopener noreferrer">
            University application page
        </a>
    </section>

    <section class="ucc-content-card">
        <h3>Need help?</h3>
        <a href="mailto:{{ config('department.hod_email') }}">Email the Head of Department</a>
    </section>
@endsection
