@extends('layouts/layoutMaster')

@section('title', 'Admins')


@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/jQueryFancibox/css/jquery.fancybox.min.css') }}">
<style>

</style>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Admins /</span> Admin Detail
</h4>

<div class="row">
  <div class="col-12">
    @include('include.flashMessage')
    <div class="card">
      <h5 class="card-header crud">Admin Info</h5>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm table-hover">
            <tbody>
              <tr>
                <th style="width: 20%;">ID</th>
                <td style="width: 80%;">{{ $admin->id }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Name</th>
                <td style="width: 80%;">{{ $admin->name }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Email</th>
                <td style="width: 80%;">{{ $admin->email }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Phone</th>
                <td style="width: 80%;">{{ $admin->phone }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Role</th>
                <td style="width: 80%;">{{ $admin->role->display_name ?? '' }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Status</th>
                <td style="width: 80%;">{!! Helper::activeStatusLabel($admin->status) !!}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Created At</th>
                <td style="width: 80%;">
                  {{ $admin->created_at->diffForHumans() }}
                  <br>
                  <small>{{ $admin->created_at->format('d-m-Y H:i:s') }}</small>
                </td>
              </tr>
              <tr>
                <th style="width: 20%;">Updated At</th>
                <td style="width: 80%;">
                  {{ $admin->updated_at->diffForHumans() }}
                  <br>
                  <small>{{ $admin->updated_at->format('d-m-Y H:i:s') }}</small>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer">
        <div class="d-flex gap-3">
          <a href="{{ route('admin.admins.index') }}" type="button"
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
