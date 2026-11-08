@extends('layouts.app')

@section('title', 'Faculty & Staff')

@section('content')
    <h2>Faculty &amp; Staff Directory</h2>

    {{-- Search controls used by ucc-student-hub.js. --}}
    <div data-ucc-filter-list>
        <label for="staff-search">Search staff</label>
        <input id="staff-search" type="search" data-ucc-search placeholder="Name, role, or subject">
        <p data-ucc-result-count role="status"></p>

        {{-- Staff details from config/department.php. --}}
        <div class="ucc-content-grid">
            @foreach(config('department.staff') as $member)
                <article class="ucc-content-card" data-ucc-filter-card data-ucc-search-text="{{ implode(' ', $member) }}">
                    @if($member['photo'])
                    <img class="ucc-staff-photo" src="{{ asset('images/'.$member['photo']) }}" alt="{{ $member['name'] }}" width="88" height="88">
                    @endif
                    <h3>{{ $member['name'] }}</h3>
                    <p>{{ $member['role'] }}</p>
                    <p>{{ $member['area'] }}</p>
                    <p>{{ $member['office'] }}</p>
                    <p><a href="tel:{{ $member['dial'] }}">{{ $member['phone'] }}</a></p>
                    <p><a href="mailto:{{ $member['email'] }}">{{ $member['email'] }}</a></p>
                </article>
            @endforeach
        </div>

        <div class="ucc-content-card" data-ucc-empty-results hidden>
            <p>No matching staff found.</p>
            <button type="button" data-ucc-reset-filters>Clear search</button>
        </div>
    </div>
@endsection
