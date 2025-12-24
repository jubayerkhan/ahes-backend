@extends('layouts/layoutMaster')

@section('title', 'Testimonial Detail')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/jQueryFancibox/css/jquery.fancybox.min.css') }}">
<style>

</style>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Testimonial /</span> Testimonial Detail
</h4>

<div class="row">
  <div class="col-12">
    @include('include.flashMessage')
    <div class="card">
      <h5 class="card-header crud">Testimonial Info</h5>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm table-hover">
            <tbody>
              <tr>
                <th style="width: 20%;">Name</th>
                <td style="width: 80%;">{{ $testimonial->name }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Icon</th>
                <td style="width: 80%;"><img src="{{ asset('storage/' . $testimonial->icon) }}" alt="Icon" width="50"></td>
              </tr>

              <tr>
                <th style="width: 20%;">University</th>
                <td style="width: 80%;">{{ $testimonial->university }}</td>
              </tr>
              <tr>
                <th style="width: 20%;">Description</th>
                <td style="width: 80%;">{{ $testimonial->description }}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Status</th>
                <td style="width: 80%;">{!! Helper::activeStatusLabel($testimonial->is_active) !!}</td>
              </tr>

              <tr>
                <th style="width: 20%;">Created At</th>
                <td style="width: 80%;">
                  {{ $testimonial->created_at->diffForHumans() }}
                  <br>
                  <small>{{ $testimonial->created_at->format('d-m-Y H:i:s') }}</small>
                </td>
              </tr>
              <tr>
                <th style="width: 20%;">Updated At</th>
                <td style="width: 80%;">
                  {{ $testimonial->updated_at->diffForHumans() }}
                  <br>
                  <small>{{ $testimonial->updated_at->format('d-m-Y H:i:s') }}</small>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer">
        <div class="d-flex gap-3">
          <a href="{{ route('admin.testimonials.index') }}" type="button"
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
