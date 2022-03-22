<?php
function appendRepository($repository)
{
    // $repository->loadCount('stars');
    // $repository->loadCount('clones');
    // $repository->openPullsCount = $repository->pulls()->where('status', 'open')->count();
    $repository->load('parent','user');

    if (auth()->check()) {
        $repository->isStared = $repository->isStaredBy(auth()->user());

        $repository->hasCloned = $repository->clonedBy(auth()->user());
        $repository->hasClonedRepository = auth()->user()->repositories()->where('parent_id', $repository->id)->first();
        $repository->canEdit = (int)auth()->id() === (int)$repository->user->id;
    }

    return $repository;
}


if (!function_exists('route_class')) {
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

if (!function_exists('make_excerpt')) {
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return str()->limit($excerpt, $length);
    }
}
