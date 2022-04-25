@if ( $errors->count()> 0)
<div class="alert alert-danger">
  <div class="mt-2"><b>有错误发生：</b></div>
  <ul class="mt-2 mb-2">
    @foreach ($errors->all() as $error)
    <li><i class="fa fa-xmark"></i> {{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
