{{-- @extends('layouts.app')


@section('content')
test
<i class="fa-solid fa-beer-mug-empty"></i>
<i class="fa fa-meteor"></i>
@endsection --}}
{{json_encode(auth()->check())}}
<br>
111111111111
<br>
@json(auth()->check())
