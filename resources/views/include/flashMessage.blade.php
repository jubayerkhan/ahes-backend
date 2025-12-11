@if(session('success'))
<div class="alert alert-success alert-dismissible d-flex align-items-baseline" role="alert">
  <span class="alert-icon alert-icon-md me-2">
    <i class="ti ti-check ti-sm"></i>
  </span>
  <div class="d-flex flex-column ps-1">
    <h5 class="alert-heading mb-2">Success!</h5>
    <p class="mb-0">{{ session('success') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
  <span class="alert-icon alert-icon-md me-2">
    <i class="ti ti-ban ti-sm"></i>
  </span>
  <div class="d-flex flex-column ps-1">
    <h5 class="alert-heading mb-2">Error!</h5>
    <p class="mb-0">{{ session('error') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible d-flex align-items-baseline" role="alert">
  <span class="alert-icon alert-icon-md me-2">
    <i class="ti ti-bell ti-sm"></i>
  </span>
  <div class="d-flex flex-column ps-1">
    <h5 class="alert-heading mb-2">Warning!</h5>
    <p class="mb-0">{{ session('warning') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif

@if(session('status'))
<div class="alert alert-success alert-dismissible d-flex align-items-baseline" role="alert">
  <span class="alert-icon alert-icon-md me-2">
    <i class="ti ti-check ti-sm"></i>
  </span>
  <div class="d-flex flex-column ps-1">
    <h5 class="alert-heading mb-2">Success!</h5>
    <p class="mb-0">{{ session('status') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
</div>
@endif
