@extends('layouts/layoutMaster')

@section('title', 'Services')

@section('page-style')
    <style>

    </style>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-1">
        <span class="text-muted fw-light">Services /</span> Service List
    </h4>

    @include('include.flashMessage')

    <div class="card">
        <h5 class="card-header crud">Service List</h5>

        {{ html()->form('GET')->route('admin.services.index')->open() }}
        <div class="card-body py-0">
            <div class="row">
                <div class="col-md-3 form-group mb-3">
                    {{ html()->label('Name', 'name')->class('form-label') }}
                    {{ html()->text('name', request()->get('name'))->class('form-control') }}
                </div>

                <div class="col-md-3 form-group mb-3">
                    {{ html()->label('Email', 'email')->class('form-label') }}
                    {{ html()->text('email', request()->get('email'))->class('form-control') }}
                </div>

                <div class="col-md-3 form-group mb-3">
                    {{ html()->label('Phone', 'phone')->class('form-label') }}
                    {{ html()->text('phone', request()->get('phone'))->class('form-control') }}
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
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Feature</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-icon btn-outline-info waves-effect"
                                        href="{{ route('admin.services.show', $service->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-custom-class="tooltip-info" title="Detail">
                                        <i class="tf-icons ti ti-eye"></i>
                                    </a>

                                    @if(
                                            auth('admin')->user()->hasRole('admin') ||
                                            auth('admin')->user()->hasPermission(['admin-services-update'])
                                        )
                                        <a class="btn btn-sm btn-icon btn-outline-primary waves-effect"
                                            href="{{ route('admin.services.edit', $service->id) }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-custom-class="tooltip-primary" title="Edit">
                                            <i class="tf-icons ti ti-pencil"></i>
                                        </a>
                                    @endif

                                    @if(
                                            auth('admin')->user()->hasRole('admin') ||
                                            auth('admin')->user()->hasPermission(['admin-services-delete'])
                                        )
                                        <a class="btn btn-sm btn-icon btn-outline-danger waves-effect" href="javascript:void(0);"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger"
                                            title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $service->id }}').submit(); } event.returnValue = false; return false;">
                                            <i class="tf-icons ti ti-trash"></i>
                                        </a>
                                        {{ html()->form('DELETE')->route('admin.services.destroy', $service->id)->id('deleteForm' . $service->id)->open() }}
                                        {{ html()->form()->close() }}
                                    @endif
                                </td>
                                <td>{{ $service->title }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $service->icon) }}" alt="Icon" width="50">
                                </td>

                                <td>{{ $service->description }}</td>

                                <td class="text-center">{!! Helper::activeStatusLabel($service->is_active) !!}</td>

                                <td class="text-center">{!! Helper::activeStatusLabel($service->is_feature) !!}</td>

                                <td>
                                    {{ $service->created_at->diffForHumans() }}
                                    <br>
                                    <small>{{ $service->created_at->format('d-m-Y H:i:s') }}</small>
                                </td>
                                <td>
                                    {{ $service->updated_at->diffForHumans() }}
                                    <br>
                                    <small>{{ $service->updated_at->format('d-m-Y H:i:s') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer pb-0">
            <ul class="pagination pagination-sm m-0 justify-content-end">
                Page {{ $services->currentPage() }} , showing
                {{ $services->count() }}
                records out of {{ $services->total() }} total
            </ul>
        </div>
        <div class="card-footer py-2">
            <ul class="pagination pagination-sm m-0 justify-content-end">
                {{ $services->appends(request()->all())->links() }}
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