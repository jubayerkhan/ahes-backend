@extends('layouts/layoutMaster')

@section('title', 'Activity Log')


@section('page-style')
<style>

</style>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Users /</span> Log List
</h4>

<div class="card">
  <h5 class="card-header crud">Log List</h5>
  {{ html()->form('GET')->route('users.activityLog')->open() }}
  <div class="card-body py-0">
    <div class="row">
      <div class="col-md-3 form-group mb-3">
        {{ html()->label('Action From', 'causer_type')->class('form-label') }}
        {{ html()->select('causer_type', ['0'=>'All']+Config::get('constants.CAUSER_TYPES_DROPDOWN'), request()->get('causer_type'))->class('select2 form-select') }}
      </div>

      <div class="col-md-3 form-group mb-3">
        {{ html()->label('Action By', 'causer')->class('form-label') }}
        {{ html()->select('causer', ['0'=>'All']+$users, request()->get('causer'))->class('select2 form-select') }}
      </div>

      <div class="col-md-3 form-group mb-3">
        {{ html()->label('MODEL', 'model')->class('form-label') }}
        {{ html()->select('model', ['0'=>'All']+Config::get('constants.MODELS'), request()->get('model'))->class('select2 form-select') }}
      </div>

      <div class="col-md-3 form-group mb-3">
        {{ html()->label('Event', 'event')->class('form-label') }}
        {{ html()->select('event', ['0'=>'All']+Config::get('constants.EVENTS'), request()->get('event'))->class('select2 form-select') }}
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>
      </div>
    </div>
  </div>
  {{ html()->form()->close() }}

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-sm table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Event</th>
            <th>Model</th>
            <th>Changes</th>
            <th>Action By</th>
            <th>Action At</th>
            {{-- <th class="text-center">Actions</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach ($logs as $log)
          <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->event }}</td>
            <td>{{ $log->subject_type }}</td>
            <td style="max-width: 500px">{{ $log->properties }}</td>
            <td>{{ $log->causer->name ?? '' }}</td>
            <td class="text-nowrap">
              {{ $log->created_at->diffForHumans() }}
              <br>
              <small>{{ $log->created_at->format('d-m-Y H:i:s') }}</small>
            </td>
            {{-- <td class="text-center">
              <a class="btn btn-sm btn-icon btn-outline-info waves-effect" href="javascript:void(0);"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" title="Detail">
                <i class="tf-icons ti ti-eye"></i>
              </a>
            </td> --}}
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-footer pb-0">
    <ul class="pagination pagination-sm m-0 justify-content-end">
      Page {{ $logs->currentPage() }} , showing
      {{ $logs->count() }}
      records out of {{ $logs->total() }} total
    </ul>
  </div>
  <div class="card-footer py-2">
    <ul class="pagination pagination-sm m-0 justify-content-end">
      {{ $logs->appends(request()->all())->links() }}
    </ul>
  </div>
</div>
@endsection

@section('page-script')
<script>
  'use strict';

(function () {



})();
</script>
@endsection
