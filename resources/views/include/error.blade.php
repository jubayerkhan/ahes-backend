@if(count($errors)>0)
<div class="alert alert-warning alert-dismissible d-flex align-items-baseline" role="alert">
  <span class="alert-icon alert-icon-md me-2">
    <i class="ti ti-bell ti-sm"></i>
  </span>
  <div class="d-flex flex-column ps-1">
    <h5 class="alert-heading mb-2">Error!</h5>
    @foreach($errors->all() as $error)
    <p class="mb-1">{{$error}}</p>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif
