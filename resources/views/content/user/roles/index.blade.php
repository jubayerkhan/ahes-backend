@extends('layouts/layoutMaster')

@section('title', 'Roles')

@section('page-style')
<style>

</style>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-1">
  <span class="text-muted fw-light">Roles /</span> Role List
</h4>

@include('include.flashMessage')

<div class="card">
  <h5 class="card-header crud">Role List</h5>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-bordered table-sm table-hover">
        <thead>
          <tr>
            <th class="text-center">Actions</th>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $role)
          <tr class="@if($role->name == 'admin') disabled @endif">
            <td class="text-center">
              @if ($role->name != 'admin')

              @if(auth('web')->user()->hasRole('admin') ||
              auth('web')->user()->hasPermission(['user-roles-update']))
              <a class="btn btn-sm btn-icon btn-outline-primary waves-effect"
                href="{{ route('roles.edit', $role->id) }}" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-custom-class="tooltip-primary" title="Edit">
                <i class="tf-icons ti ti-pencil"></i>
              </a>
              @endif

              @if(auth('web')->user()->hasRole('admin') ||
              auth('web')->user()->hasPermission(['user-roles-delete']))
              <a class="btn btn-sm btn-icon btn-outline-danger waves-effect" href="javascript:void(0);"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" title="Delete"
                onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $role->id }}').submit(); } event.returnValue = false; return false;">
                <i class="tf-icons ti ti-trash"></i>
              </a>
              {{ html()->form('DELETE')->route('roles.destroy',$role->id)->id('deleteForm'.$role->id)->open() }}
              {{ html()->form()->close() }}
              @endif

              @endif
            </td>
            <td>{{ $role->id }}</td>
            <td>{{ $role->display_name }}</td>
            <td>{{ $role->description }}</td>
            <td class="text-center">{!! Helper::activeStatusLabel($role->status) !!}</td>
            <td>
              {{ $role->created_at->diffForHumans() }}
              <br>
              <small>{{ $role->created_at->format('d-m-Y H:i:s') }}</small>
            </td>
            <td>
              {{ $role->updated_at->diffForHumans() }}
              <br>
              <small>{{ $role->updated_at->format('d-m-Y H:i:s') }}</small>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-footer pb-0">
    <ul class="pagination pagination-sm m-0 justify-content-end">
      Page {{ $roles->currentPage() }} , showing
      {{ $roles->count() }}
      records out of {{ $roles->total() }} total
    </ul>
  </div>
  <div class="card-footer py-2">
    <ul class="pagination pagination-sm m-0 justify-content-end">
      {{ $roles->appends(request()->all())->links() }}
    </ul>
  </div>
</div>
@section('page-script')
<script>

</script>
@endsection


@endsection
