@extends('layouts/layoutMaster')

@section('title', 'Testimonials')

@section('page-style')
    <style>

    </style>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-1">
        <span class="text-muted fw-light">Testimonials /</span> Testimonial List
    </h4>

    @include('include.flashMessage')

    <div class="card">
        <h5 class="card-header crud">Testimonial List</h5>

        {{ html()->form('GET')->route('admin.testimonials.index')->open() }}
        <div class="card-body py-0">
            <div class="row">
                <div class="col-md-3 form-group mb-3">
                    {{ html()->label('Name', 'name')->class('form-label') }}
                    {{ html()->text('name', request()->get('name'))->class('form-control') }}
                </div>

                <div class="col-md-3 form-group mb-3">
                    {{ html()->label('University', 'university')->class('form-label') }}
                    {{ html()->text('university', request()->get('university'))->class('form-control') }}
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-sm-2 me-1 waves-effect waves-light">Submit</button>
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Actions</th>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>University</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-icon btn-outline-info waves-effect"
                                        href="{{ route('admin.testimonials.show', $testimonial->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-custom-class="tooltip-info" title="Detail">
                                        <i class="tf-icons ti ti-eye"></i>
                                    </a>

                                    @if(
                                            auth('admin')->user()->hasRole('admin') ||
                                            auth('admin')->user()->hasPermission(['admin-admins-update'])
                                        )
                                        <a class="btn btn-sm btn-icon btn-outline-primary waves-effect"
                                            href="{{ route('admin.testimonials.edit', $testimonial->id) }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-custom-class="tooltip-primary" title="Edit">
                                            <i class="tf-icons ti ti-pencil"></i>
                                        </a>
                                    @endif

                                    @if(
                                            auth('admin')->user()->hasRole('admin') ||
                                            auth('admin')->user()->hasPermission(['admin-admins-delete'])
                                        )
                                        <a class="btn btn-sm btn-icon btn-outline-danger waves-effect" href="javascript:void(0);"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger"
                                            title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $testimonial->id }}').submit(); } event.returnValue = false; return false;">
                                            <i class="tf-icons ti ti-trash"></i>
                                        </a>
                                        {{ html()->form('DELETE')->route('admin.testimonials.destroy', $testimonial->id)->id('deleteForm' . $testimonial->id)->open() }}
                                        {{ html()->form()->close() }}
                                    @endif
                                </td>
                                <td>{{ $testimonial->name }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $testimonial->icon) }}" alt="Icon" width="50">
                                </td>

                                <td>{{ $testimonial->university }}</td>
                                <td>{{ $testimonial->description }}</td>
                                
                                <td class="text-center">{!! Helper::activeStatusLabel($testimonial->is_active) !!}</td>

                                <td>
                                    {{ $testimonial->created_at->diffForHumans() }}
                                    <br>
                                    <small>{{ $testimonial->created_at->format('d-m-Y H:i:s') }}</small>
                                </td>
                                <td>
                                    {{ $testimonial->updated_at->diffForHumans() }}
                                    <br>
                                    <small>{{ $testimonial->updated_at->format('d-m-Y H:i:s') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer pb-0">
            <ul class="pagination pagination-sm m-0 justify-content-end">
                Page {{ $testimonials->currentPage() }} , showing
                {{ $testimonials->count() }}
                records out of {{ $testimonials->total() }} total
            </ul>
        </div>
        <div class="card-footer py-2">
            <ul class="pagination pagination-sm m-0 justify-content-end">
                {{ $testimonials->appends(request()->all())->links() }}
            </ul>
        </div>
    </div>
@endsection

<script>
    'use strict';

    document.addEventListener('DOMContentLoaded', function (e) {

        (function () {
            // Select2 Option
            let select2 = $('.select2');
            if (select2.length) {
                select2.each(function () {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }
        })();
    });

</script>