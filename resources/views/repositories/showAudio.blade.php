@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-bg-white tw-py-4">
        <show-audio :repository="@json($repository)" :commit="@json($commit)"></show-audio>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/showAudio.js') }}"></script>
@endsection
