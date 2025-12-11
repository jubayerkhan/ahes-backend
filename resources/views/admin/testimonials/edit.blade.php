@extends('layouts/layoutMaster')

@section('title', 'Testimonial')

@section('page-style')
  <style>

  </style>
@endsection


@section('content')
  <h4 class="fw-bold py-3 mb-1">
    <span class="text-muted fw-light">Testimonials /</span> Testimonial Edit
  </h4>

  <div class="row">
    <div class="col-12">
      @include('include.error')
      @include('include.flashMessage')
      <div class="card">
        <h5 class="card-header crud">Edit Testimonial Info</h5>

        <div class="card-body">
          {{ html()->model($testimonial)->form('PATCH')->route('admin.testimonials.update', $testimonial->id)->class('row g-3')->id('validateForm')->attribute('enctype', 'multipart/form-data')->open() }}
          <div class="col-md-6">
            <div class="form-group mb-3">
              {{ html()->label('Name', 'name')->class('form-label') }}
              {{ html()->text('name')->class('form-control') }}
            </div>

            <div class="form-group mb-3">
              {{ html()->label('Icon (Image)', 'icon')->class('form-label') }}
              {{ html()->file('icon')->class('form-control')->name('icon') }}
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group mb-3">
              {{ html()->label('University', 'university')->class('form-label') }}
              {{ html()->textarea('university')->class('form-control')->rows(6) }}
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group mb-3">
              {{ html()->label('Description', 'description')->class('form-label') }}
              {{ html()->textarea('description')->class('form-control')->rows(6) }}
            </div>
          </div>

          <div class="form-check form-check-primary mt-4">
            {{ html()->checkbox('is_active', null, '1')->class('form-check-input') }}
            {{ html()->label('&nbsp;Active', 'status')->class('form-check-label') }}
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>

            @if(
                auth('admin')->user()->hasRole('admin') ||
                auth('admin')->user()->hasPermission(['admin-admins-read'])
              )
              <a href="{{ route('admin.testimonials.index') }}" type="button" class="btn btn-label-danger waves-effect">Cancel</a>
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
            title: {
              validators: {
                notEmpty: {
                  message: 'Please enter your name'
                }
              }
            },
            description: {
              validators: {
                notEmpty: {
                  message: 'Please enter your description'
                }
              }
            },
            university: {
              validators: {
                notEmpty: {
                  message: 'Please enter your university'
                }
              }
            },
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