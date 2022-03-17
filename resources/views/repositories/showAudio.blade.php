@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)


@section('content')

    <div class="tw-bg-white tw-py-4">
        <show-audio :repository='@json($repository->toJson())' @if ($commit)
            :commit='@json($commit->toJson())'
            @endif :can_edit='@json(auth()->check() &&
            auth()->user()->isAuthorOf($repository))'>
        </show-audio>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/table.js') }}"></script>
@endsection
