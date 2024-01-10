@extends('layouts/layoutMaster')

@section('title', empty($user) ? 'Add User' : 'Edit User')

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
    <script>
        var select2 = $('.select2');
        if (select2.length) {
            select2.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select Role',
                    dropdownParent: $this.parent()
                });
            });
        }
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Users /</span> {{ empty($user) ? 'Add User' : 'Edit User' }}</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl-10 offset-xl-1">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $user->name ?? 'New User' }}</h5>
                </div>
                <div class="card-body">
                    <form class="add-new-user pt-0"
                        action="{{ empty($user) ? route('users.store') : route('users.update', $user) }}" method="POST">
                        @csrf
                        @if (!empty($user))
                            @method('PATCH')
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="add-user-fullname">Full Name</label>
                            <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe"
                                name="name" aria-label="John Doe" value="{{ old('name') ?? ($user->name ?? '') }}"
                                required />
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="add-user-email">Email</label>
                            <input type="email" id="add-user-email" class="form-control"
                                placeholder="john.doe@example.com" autocomplete="off" aria-label="john.doe@example.com"
                                name="email" value="{{ old('email') ?? ($user->email ?? '') }}" required />
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="add-user-password">Password</label>
                            <input type="password" id="add-user-password" autocomplete="off" class="form-control"
                                placeholder="Type password" aria-label="Type password" name="password" value=""
                                @required(empty($user)) />
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (empty($user->is_super_admin))
                            <div class="mb-3">
                                <label class="form-label" for="user-role">Role</label>
                                <select id="user-role" name="roles[]" multiple
                                    class="form-select select2 select2-primary text-capitalize" autocomplete="off" required>
                                    @foreach ($options['roles'] as $roleId => $roleName)
                                        <option value="{{ $roleId }}" class="text-capitalize"
                                            @selected(in_array($roleId, old('roles') ?? (!empty($user) ? $user?->roles->pluck('id')->toArray() : [])))>
                                            {{ $roleName }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="switch switch-outline">
                                    <span class="switch-label">Active?</span>
                                    <input type="checkbox" name="status" class="switch-input" @checked(!empty($user) ? $user->status : true)
                                        value="1" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                                </label>
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
