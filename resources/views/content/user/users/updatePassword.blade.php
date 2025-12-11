@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Users')

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-account-settings.css')}}" />
@endsection


@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Users /</span> Edit Password
</h4>

<div class="row">
  <div class="col-md-12">
    <!-- Update Password -->
    <div class="card mb-4">
      <h5 class="card-header crud">Edit Password</h5>
      <div class="card-body">
        @include('include.error')
        @include('include.flashMessage')

        {{ html()->model($user)->form('PATCH')->route('users.updatePasswordStore', $user->id)->id('formAccountSettings')->open() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-3">
              {{ html()->label('Name', 'name')->class('form-label') }}
              {{ html()->text('name')->class('form-control disabled')->id('name') }}
            </div>

            <div class="form-group mb-3">
              {{ html()->label('Email', 'email')->class('form-label') }}
              {{ html()->text('email')->class('form-control disabled')->id('email') }}
            </div>

            <div class="form-group mb-3 form-password-toggle">
              <label class="form-label" for="password">New Password</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" id="password" name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>

            <div class="form-group mb-3 form-password-toggle">
              <label class="form-label" for="password_confirmation">Confirm New Password</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>

          <div class="col-12 mb-4 d-none">
            <h6>Password Note:</h6>
            <ul class="ps-3 mb-0">
              <li class="mb-1">Minimum 6 characters long - the more, the better</li>
              <li class="mb-1">At least one lowercase character</li>
              <li>At least one number, symbol, or whitespace character</li>
            </ul>
          </div>
          <div>
            <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>

            @if(auth('web')->user()->hasRole('admin') ||
            auth('web')->user()->hasPermission(['user-users-read']))
            <a href="{{ route('users.index') }}" type="button" class="btn btn-label-danger waves-effect">Cancel</a>
            @endif
          </div>
        </div>
        {{ html()->form()->close() }}
      </div>
    </div>
    <!--/ Update Password -->



  </div>
</div>

@endsection

@section('page-script')
<script>
  'use strict';

  document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
      const formChangePass = document.querySelector('#formAccountSettings');

      // Form validation for Update password
      if (formChangePass) {
        const fv = FormValidation.formValidation(formChangePass, {
          fields: {
            password: {
              validators: {
                notEmpty: {
                  message: 'Please enter new password'
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
                  message: 'Please confirm new password'
                },
                identical: {
                  compare: function () {
                    return formChangePass.querySelector('[name="password"]').value;
                  },
                  message: 'The password and its confirm are not the same'
                },
                stringLength: {
                  min: 6,
                  message: 'Password must be more than 6 characters'
                }
              }
            }
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
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
              if (e.element.parentElement.classList.contains('input-group')) {
                e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
              }
            });
          }
        });
      }

    })();
  });

</script>
@endsection
