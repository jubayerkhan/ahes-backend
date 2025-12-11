@extends('layouts/layoutMaster')

@section('title', 'Profile Settings')

@section('page-style')
<style>

</style>
@endsection


@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Profile Settings /</span> Profile Edit
</h4>

<div class="row">
  <div class="col-md-12">
    @include('include.error')
    @include('include.flashMessage')

    {{ html()->model($user)->form('PATCH')->route('profile.update')->class('row g-3')->id('validateForm')->acceptsFiles()->open() }}
    <div class="card mb-4">
      <h5 class="card-header crud">Profile Edit info</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{ $user->image ? asset(Helper::storagePath($user->image)) : asset('assets/img/avatars/default.png') }}"
            alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="ti ti-upload d-block d-sm-none"></i>
              <input type="file" name="image" id="upload" class="account-file-input" hidden
                accept="image/png, image/jpg, image/jpeg" />
            </label>
            <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
              <i class="ti ti-refresh-dot d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <div class="text-muted">Allowed JPG, or PNG. Max size of 1000Kb</div>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-3">
              {{ html()->label('Name', 'name')->class('form-label') }}
              {{ html()->text('name')->class('form-control')->id('name') }}
            </div>

            <div class="form-group mb-3">
              {{ html()->label('Phone', 'phone')->class('form-label') }}
              {{ html()->text('phone')->class('form-control')->id('phone') }}
            </div>
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>

            <a href="{{ route('profile') }}" type="button" class="btn btn-label-danger waves-effect">Cancel</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /Account -->
  </div>
  {{ html()->form()->close() }}
</div>
</div>

@endsection

@section('page-script')
<script>
  'use strict';

  document.addEventListener('DOMContentLoaded', function (e) {

    (function () {

    //-----Form Validation -----
    const validateForm = document.getElementById('validateForm');

    const fv = FormValidation.formValidation(validateForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter your name'
            }
          }
        },
        phone: {
          validators: {
            notEmpty: {
              message: 'Please enter your phone number'
            }
          }
        }

      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.form-group'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          //* Move the error message out of the `input-group` element
          if (e.element.parentElement.classList.contains('input-group')) {
            // `e.field`: The field name
            // `e.messageElement`: The message element
            // `e.element`: The field element
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
          //* Move the error message out of the `row` element for custom-options
          if (e.element.parentElement.parentElement.classList.contains('custom-option')) {
            e.element.closest('.row').insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    });


  })();
});
</script>
@endsection
