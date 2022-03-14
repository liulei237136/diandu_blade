@extends('layouts.app')

@section('title', 'init ' . $repository->name)
@section('description', $repository->excerpt)

{{-- file_name,file_path,comment,user_name,user_id,created_at
25074.mp3,http://localhost:8000/storage/audio/1/waTFueR77JE86w8jiBNYSO3Qu3TUvsUuMBB1qHRj.mp3,,parent,1,1645518455765 --}}
@section('content')
    <div class="tw-bg-white tw-py-4">
        <div class="container">
            <init-repository :repository="@json($repository)" :user="@json(auth()->user())"></init-repository>
        </div>
    </div>
@stop


