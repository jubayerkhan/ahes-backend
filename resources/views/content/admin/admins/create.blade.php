@extends('layouts/layoutMaster')

@section('title', 'Admins')

@section('page-style')
<style>

</style>
@endsection


@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Admins /</span> New Admin
</h4>

<div class="row">
  <div class="col-12">
    @include('include.error')
    @include('include.flashMessage')
    <div class="card">
      <h5 class="card-header crud">New Admin Info</h5>

      <div class="card-body">
        {{ html()->form('POST')->route('admin.admins.store')->class('row g-3')->id('validateForm')->open() }}
        <div class="col-md-6">
          <div class="form-group mb-3">
            {{ html()->label('Role', 'role_id')->class('form-label') }}
            {{ html()->select('role_id', [''=>'Select']+$roles, null)->class('select2 form-select')->attributes(['data-allow-clear'=>true]) }}
          </div>

          <div class="form-group mb-3">
            {{ html()->label('Name', 'name')->class('form-label') }}
            {{ html()->text('name')->class('form-control')->id('name') }}
          </div>

          <div class="form-group mb-3">
            {{ html()->label('Email', 'email')->class('form-label') }}
            {{ html()->text('email')->class('form-control')->id('email') }}
          </div>

        </div>

        <div class="col-md-6">
          <div class="form-group mb-3">
            {{ html()->label('Phone', 'phone')->class('form-label') }}
            {{ html()->text('phone')->class('form-control')->id('phone') }}
          </div>

          <div class="form-group mb-3 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" name="password" class="form-control" placeholder="············"
                required>
              <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                  class="ti ti-eye-off"></i></span>
            </div>
          </div>

          <div class="form-group mb-3 form-password-toggle">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="············" required>
              <span class="input-group-text cursor-pointer" id="basic-default-password5"><i
                  class="ti ti-eye-off"></i></span>
            </div>
          </div>

          <div class="form-check form-check-primary mt-2">
            {{ html()->checkbox('status', 1, '1')->class('form-check-input') }}
            {{ html()->label('&nbsp;Active', 'status')->class('form-check-label') }}
          </div>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>

          @if(auth('admin')->user()->hasRole('admin') ||
          auth('admin')->user()->hasPermission(['admin-admins-read']))
          <a href="{{ route('admin.admins.index') }}" type="button" class="btn btn-label-danger waves-effect">Cancel</a>
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
    const validateForm = document.getElementById('validateForm'),
    role_id = jQuery(validateForm.querySelector('[name="role_id"]'));

    const fv = FormValidation.formValidation(validateForm, {
      fields: {
        role_id: {
          validators: {
            notEmpty: {
              message: 'Please select your role'
            }
          }
        },
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter your name'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        },
        password: {
          validators: {
            notEmpty: {
              message: 'Please enter your password'
            },
            stringLength: {
              min: 6,
              message: 'Password must be more than 6 characters'
            }
          }
        },
        password_confirmation: {
          validators: {
            notEmpty: {
              message: 'Please re-enter your password'
            },
            stringLength: {
              min: 6,
              message: 'Password must be more than 6 characters'
            },
            identical: {
              compare: function () {
                return validateForm.querySelector('[name="password"]').value;
              },
              message: 'The password and its confirm are not the same'
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

    // Select2 on changed
    if (role_id.length) {
      role_id.wrap('<div class="position-relative"></div>');
      role_id
        .select2({
          placeholder: 'Select Option',
          dropdownParent: role_id.parent()
        })
        .on('change', function () {
          // Revalidate the color field when an option is chosen
          fv.revalidateField('role_id');
        });
    }


  })();
});
</script>
@endsection
