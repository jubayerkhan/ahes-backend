@extends('layouts/layoutMaster')

@section('title', 'Settings')

@section('page-style')
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
/>
<style>

</style>
@endsection


@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Settings /</span> Site Settings
</h4>

<div class="row">
  <div class="col-12">
    @include('include.error')
    @include('include.flashMessage')
    <div class="card">
      <h5 class="card-header crud">Site Settings Info</h5>

      <div class="card-body">
        {{ html()->form('POST')->route('admin.site-settings.store')->class('row
        g-3')->acceptsFiles()->id('validateForm')->open() }}
        <div class="col-md-12">
          @foreach($configs as $config)
          @php
          $type = $config['TYPE'];
          @endphp

          @if ($type == 'text')
          <div class="form-group mb-3">
            {{ html()->label(ucwords(strtolower(str_replace('_',' ',$config['NAME']))), $config['NAME'])->class('form-label') }}
            {{ html()->text('settings['.$config['NAME'].']')->value(isset($settings[$config['NAME']]) ?
            $settings[$config['NAME']] : '')->placeholder(isset($config['PLACEHOLDER']) ? $config['PLACEHOLDER'] :
            '')->class('form-control') }}
          </div>
          @elseif ($type == 'textarea')
          <div class="form-group mb-3">
            {{ html()->label(ucwords(strtolower(str_replace('_',' ',$config['NAME']))),
            $config['NAME'])->class('form-label') }}
            {{ html()->textarea('settings['.$config['NAME'].']')->value(isset($settings[$config['NAME']]) ?
            $settings[$config['NAME']] : '')->class('form-control resize-vertical')->rows('3') }}
          </div>
          @elseif ($type == 'rte')
          <div class="form-group mb-3">
            {{ html()->label(ucwords(strtolower(str_replace('_',' ',$config['NAME']))),
            $config['NAME'])->class('form-label') }}
            {{ html()->textarea('settings['.$config['NAME'].']')->value(isset($settings[$config['NAME']]) ?
            $settings[$config['NAME']] : '')->class('form-control rte')->rows('5') }}
          </div>
          @elseif ($type == 'boolean')
          <div class="form-check form-check-primary mt-1 mb-2">
            {{ html()->checkbox('settings['.$config['NAME'].']', ((isset($settings[$config['NAME']]) &&
            $settings[$config['NAME']] == 1) ? 1 : null), '1')->class('form-check-input')->id($config['NAME']) }}
            {{ html()->label('&nbsp;'.$config['PLACEHOLDER'], $config['NAME'])->class('form-check-label') }}
          </div>
          @elseif ($type == 'file')
          <div class="form-group mb-3">
            {{ html()->label(ucwords(strtolower(str_replace('_',' ',$config['NAME']))),
            $config['NAME'])->class('form-label') }}
            <div class="custom-file mb-2">
              {{ html()->file('settings['.$config['NAME'].']') }}
            </div>
            <div style="width: 100px;">
              @if(isset($settings[$config['NAME']]))
              <a data-fancybox="gallery" data-caption="Image Caption"
                href="{{ asset(Helper::storagePath($settings[$config['NAME']])) }}">
                <img class="img-thumbnail" src="{{ asset(Helper::storagePath($settings[$config['NAME']])) }}" alt="">
              </a>
              @endif
            </div>
          </div>
          @endif
          @endforeach

        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>
        </div>
        {{ html()->form()->close() }}
      </div>
    </div>
  </div>
  <!-- /FormValidation -->
</div>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
  'use strict';

  document.addEventListener('DOMContentLoaded', function (e) {

    (function () {
      Fancybox.bind("[data-fancybox]", {
        // Your custom options
      });

      $('#GOOGLE_CAPTCHA_ENABLE').on('click', function(e){
        if($(this).prop('checked')) {
            $('#ENABLE_ENTERPRISE_CAPTCHA').prop('checked', false)
          }
      });

      $('#ENABLE_ENTERPRISE_CAPTCHA').on('click', function(e){
        if($(this).prop('checked')) {
            $('#GOOGLE_CAPTCHA_ENABLE').prop('checked', false)
          }
      });

  })();
});
</script>
@endsection
