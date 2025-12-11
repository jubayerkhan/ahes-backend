@extends('layouts/layoutMaster')

@section('title', 'Admins')


@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/jQueryFancibox/css/jquery.fancybox.min.css') }}">
<style>

</style>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Services /</span> Service Detail
</h4>

<div class="row">
  <div class="col-12">
    @include('include.flashMessage')
    <div class="card">
      <h5 class="card-header crud">Service Info</h5>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm table-hover">
            <tbody>
              <tr>
                <th style="width: 20%;">Title</th>
                <td style="width: 80%;">{{ $service->title }}</td>
              </tr>

              
              <tr>
                <th style="width: 20%;">Icon</th>
                <td style="width: 80%;"><img src="{{ asset('storage/' . $service->icon) }}" alt="Icon" width="50"></td>
              </tr>

              <tr>
                <th style="width: 20%;">Description</th>
                <td style="width: 80%;">{{ $service->description }}</td>
              </tr>
              
              <tr>
                <th style="width: 20%;">Status</th>
                <td style="width: 80%;">{!! Helper::activeStatusLabel($service->is_active) !!}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Created At</th>
                <td style="width: 80%;">
                  {{ $service->created_at->diffForHumans() }}
                  <br>
                  <small>{{ $service->created_at->format('d-m-Y H:i:s') }}</small>
                </td>
              </tr>
              <tr>
                <th style="width: 20%;">Updated At</th>
                <td style="width: 80%;">
                  {{ $service->updated_at->diffForHumans() }}
                  <br>
                  <small>{{ $service->updated_at->format('d-m-Y H:i:s') }}</small>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer">
        <div class="d-flex gap-3">
          <a href="{{ route('admin.services.index') }}" type="button"
            class="btn btn-label-danger waves-effect">Back</a>
        </div>
      </div>
    </div>
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
