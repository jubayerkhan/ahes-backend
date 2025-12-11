@extends('layouts/layoutMaster')

@section('title', 'Roles')

@section('page-style')
<style>
  @media (max-width: 767.98px) {

    h5,
    .h5 {
      font-size: 16px !important;
    }
  }
</style>
@endsection


@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Roles /</span> New Role
</h4>

<div class="row">
  <div class="col-12">
    @include('include.error')
    @include('include.flashMessage')
    <div class="card">
      <h5 class="card-header crud">New Role Info</h5>

      <div class="card-body">
        {{ html()->form('POST')->route('admin.roles.store')->class('row g-3')->id('validateForm')->open() }}

        <div class="col-md-6">
          <div class="form-group mb-3">
            {{ html()->label('Role Name', 'display_name')->class('form-label') }}
            {{ html()->text('display_name')->class('form-control')->id('display_name') }}
          </div>

          <div class="form-group mb-3">
            {{ html()->label('Description', 'description')->class('form-label') }}
            {{ html()->textarea('description')->class('form-control resize-vertical')->id('description')->rows('3') }}
          </div>

          <div class="form-check form-check-primary mt-2">
            {{ html()->checkbox('status', 1, '1')->class('form-check-input') }}
            {{ html()->label('&nbsp;Active', 'status')->class('form-check-label') }}
          </div>
        </div>

        <div class="col-md-6">

        </div>

        <div class="col-12">
          @foreach($permissionGroups as $permissionGroup)
          <div class="border rounded p-3 {{ !$loop->last ? 'mb-3' : ''}}">
            <h5 class="d-flex mt-3 mb-2">
              <span class="permissionscategory me-2">{{ $loop->iteration }}. {{ $permissionGroup->name }}</span>
              <div class="selectrevertcategory form-check form-check-primary">
                <input type="checkbox" id="selectCategotyAll{{ $permissionGroup->id }}"
                  class="form-check-input selectcategory">
                <label class="form-check-label" for="selectCategotyAll{{ $permissionGroup->id }}">Select
                  All</label>
              </div>
            </h5>

            <div class="col-md-12 mt-0 mb-2">
              <div class="row">
                @foreach($permissionGroup->permissions as $permission)
                <div class="col-md-3">
                  <div class="form-check form-check-primary">
                    {{ html()->checkbox('permissions[]', 0, $permission->id)->class('form-check-input
                    check')->id('checkboxPermission'.$permission->id) }}
                    {{ html()->label($permission->display_name,
                    'checkboxPermission'.$permission->id)->class('form-check-label permissionlabel') }}
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>

          @if(auth('admin')->user()->hasRole('admin') ||
          auth('admin')->user()->hasPermission(['admin-roles-read']))
          <a href="{{ route('admin.roles.index') }}" type="button" class="btn btn-label-danger waves-effect">Cancel</a>
          @endif
        </div>
        {{ html()->form()->close() }}
      </div>
    </div>
  </div>
  <!-- /FormValidation -->
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
        display_name: {
          validators: {
            notEmpty: {
              message: 'Please enter role name.'
            }
          }
        },
        description: {
          validators: {
            notEmpty: {
              message: 'Please enter role description.'
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

  // Category wise Select
  $('.selectcategory').on('click', function (event) {
      // alert($(this).parent().parent().attr('class'));
      if($(this).prop("checked") == true){
          $(this).parent().parent().next().find('.check').prop("checked", true);
      }else{
          $(this).parent().parent().next().find('.check').prop("checked", false);
      }

  });
});
</script>

@endsection
