@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <h2>IT Courses</h2>
    <p><a href="https://www.ucc.edu.jm/programmes/tm/bsc-in-information-technology" target="_blank" rel="noopener noreferrer">UCC BSc in Information Technology</a></p>
    <p><a href="https://ucc.edu.jm/sites/default/files/files/bsc_ba_majoring_in_information_system_management_structure.pdf" target="_blank" rel="noopener noreferrer">Course reference: UCC programme structure (2016)</a></p>

    {{-- Show an error when the catalogue cannot load. --}}
    @if($unavailable)
        <div class="ucc-content-card" role="alert">
            <p>The catalogue is temporarily unavailable.</p>
            <a class="ucc-action-button" href="{{ route('courses.index') }}">Try again</a>
        </div>
    @else
        <div data-ucc-filter-list>
            {{-- Search and year filters. --}}
            <div class="ucc-course-filters">
                <div>
                    <label for="course-search">Search courses</label>
                    <input id="course-search" type="search" data-ucc-search placeholder="Course name or code">
                </div>
                <div>
                    <label for="course-year">Year</label>
                    <select id="course-year" data-ucc-course-year>
                        <option value="">All years</option>
                        @foreach(range(1, 4) as $year)
                            <option value="{{ $year }}">Year {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <p data-ucc-result-count role="status">{{ count($courses) }} courses</p>

            {{-- Course records supplied by the controller. --}}
            <div class="ucc-content-grid">
                @foreach($courses as $course)
                    <article class="ucc-content-card" data-ucc-filter-card data-ucc-course-year="{{ $course['level'] }}"
                        data-ucc-search-text="{{ $course['code'].' '.$course['name'].' '.$course['category'].' '.$course['description'] }}">
                        <h3>{{ $course['code'] }} - {{ $course['name'] }}</h3>
                        <p><strong>Credits:</strong> {{ $course['credits'] }}</p>
                        <p><strong>Year:</strong> {{ $course['level'] }}</p>
                        <p><strong>Pre-requisites:</strong> {{ $course['prerequisites'] }}</p>
                        <p>{{ $course['description'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="ucc-content-card" data-ucc-empty-results @if(count($courses)) hidden @endif>
                <p>No courses found.</p>
                <button type="button" data-ucc-reset-filters>Reset filters</button>
            </div>
        </div>
    @endif
@endsection
