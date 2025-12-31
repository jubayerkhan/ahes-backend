@extends('layouts/layoutMaster')

@section('title', 'Contacts')

@section('page-style')
    <style>

    </style>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-1">
        <span class="text-muted fw-light">Contacts /</span> Contact List
    </h4>

    @include('include.flashMessage')

    <div class="card">
        <h5 class="card-header crud">Contact List</h5>

        {{ html()->form('GET')->route('admin.contacts.index')->open() }}
        <div class="card-body py-0">
            <div class="row">
                <div class="col-md-3 form-group mb-3">
                    {{ html()->label('Name', 'name')->class('form-label') }}
                    {{ html()->text('name', request()->get('name'))->class('form-control') }}
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td class="text-center">
                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                            method="POST"
                                         onsubmit="return confirm('Are you sure you want to delete this contact?')">

                                        @csrf
                                            @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger" type="submit">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>

                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->subject }}</td>
                                <td>{{ $contact->comment }}</td>

                                <td>
                                    {{ $contact->created_at->diffForHumans() }}
                                    <br>
                                    <small>{{ $contact->created_at->format('d-m-Y H:i:s') }}</small>
                                </td>
                                <td>
                                    {{ $contact->updated_at->diffForHumans() }}
                                    <br>
                                    <small>{{ $contact->updated_at->format('d-m-Y H:i:s') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer pb-0">
            <ul class="pagination pagination-sm m-0 justify-content-end">
                Page {{ $contacts->currentPage() }} , showing
                {{ $contacts->count() }}
                records out of {{ $contacts->total() }} total
            </ul>
        </div>
        <div class="card-footer py-2">
            <ul class="pagination pagination-sm m-0 justify-content-end">
                {{ $contacts->appends(request()->all())->links() }}
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