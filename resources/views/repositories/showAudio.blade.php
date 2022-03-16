@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class="tw-bg-white tw-py-4">
        <show-audio :repository="{{json_encode($repository)}}" :commit="{{json_encode($commit)}}" :can_edit="{{auth()->user() && auth()->user()->isAuthorOf($repository)}}"></show-audio>
    </div>
@stop

@section('scripts')
    <script src="{{ mix('js/table.js') }}"></script>
@endsection
