@extends('layouts/layoutMaster')

@section('title', empty($role) ? 'Add Role' : 'Edit Role')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Roles /</span> {{ empty($role) ? 'Add Role' : 'Edit Role' }}</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl-10 offset-xl-1">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-capitalize">{{ $role->name ?? 'New Role' }}</h5>
                </div>
                <div class="card-body">
                    <form class="add-new-user pt-0"
                        action="{{ empty($role) ? route('roles.store') : route('roles.update', $role) }}" method="POST">
                        @csrf
                        @if (!empty($role))
                            @method('PATCH')
                        @endif
                        @if (empty($role->is_protected))
                            <div class="mb-3">
                                <label class="form-label" for="add-role-name">Role Name</label>
                                <input type="text" class="form-control" id="add-role-name" placeholder="Nurse"
                                    name="name" aria-label="Nurse" value="{{ old('name') ?? ($role->name ?? '') }}"
                                    required />
                                @error('name')
                                    <span id="basic-default-name-error" class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="switch">
                                <span class="switch-label">Is Assignable (Is Doctor)?
                                    <i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                        aria-label="Allows patients to be assigned to users with this role"
                                        data-bs-original-title="Allows patients to be assigned to users with this role"></i>
                                </span>
                                <input type="checkbox" name="is_assignable" class="switch-input"
                                    @checked($role->is_assignable ?? old('is_assignable')) value="1" />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>

                            </label>
                        </div>
                        @if (empty($role->is_protected))
                            <div class="row my-4">
                                <div class="col">
                                    <div class="accordion border" id="collapsibleSection">
                                        <div class="accordion-item active">
                                            <h2 class="accordion-header" id="headingPermissions">
                                                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsePermissions" aria-expanded="true"
                                                    aria-controls="collapsePermissions"> Role Permissions </button>
                                            </h2>
                                            <div id="collapsePermissions" class="accordion-collapse collapse show"
                                                data-bs-parent="#collapsibleSection" style="">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-flush-spacing">
                                                            <tbody>
                                                                {{-- <tr>
                                                                <td class="text-nowrap fw-medium">Administrator Access <i
                                                                        class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        aria-label="Allows a full access to the system"
                                                                        data-bs-original-title="Allows a full access to the system"></i>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="selectAll">
                                                                        <label class="form-check-label" for="selectAll">
                                                                            Select All
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr> --}}
                                                                @foreach ($options['permissions'] as $groupName => $permissionsNames)
                                                                    <tr>
                                                                        <td class="text-nowrap fw-medium">
                                                                            {{ $groupName }}
                                                                            Management</td>
                                                                        <td>
                                                                            @foreach (array_chunk($permissionsNames, 4) as $permissionsNamesChunk)
                                                                                <div class="d-flex">
                                                                                    @foreach ($permissionsNamesChunk as $permission)
                                                                                        <div
                                                                                            class="form-check me-3 me-lg-5">
                                                                                            <input class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="permissions[]"
                                                                                                id="permission-{{ $permission }}"
                                                                                                value="{{ $permission }}"
                                                                                                @checked(!empty($role) && $role->hasPermissionTo($permission))>
                                                                                            <label class="form-check-label"
                                                                                                for="permission-{{ $permission }}">
                                                                                                {{ explode('::', $permission)[1] }}
                                                                                            </label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" onclick="history.back()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
