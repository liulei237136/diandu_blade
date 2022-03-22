@extends('layouts.repository')

@section('title', $repository->name)
@section('description', $repository->excerpt)

@section('content')
    <div class=" tw-p-4">
        <edit-audio :repository="{{ json_encode($repository) }}" :commit="{{ json_encode($commit) }}"
            :user="{{ auth()->user() }}"></edit-audio>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        window.onbeforeunload = function(event) {
            return confirm('really');
        };
    </script>
@endsection
