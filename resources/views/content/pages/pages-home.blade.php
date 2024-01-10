@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-primary mb-2 rounded">
                        <i class="ti ti-calendar-due"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Appointments</h5>
                    <small class="text-muted"></small>
                    <p class="mb-2 mt-1">{{ $appointmentsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-primary mb-2 rounded">
                        <i class="ti ti-heart"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Patients</h5>
                    <small class="text-muted"></small>
                    <p class="mb-2 mt-1">{{ $patientsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="badge p-2 bg-label-primary mb-2 rounded">
                        <i class="ti ti-user"></i>
                    </div>
                    <h5 class="card-title mb-1 pt-2">Users</h5>
                    <small class="text-muted"></small>
                    <p class="mb-2 mt-1">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- User List Style -->
                <div class="col-12 col-lg-12 mb-4 mb-xl-0">
                    <div class="d-flex d-flex justify-content-between">
                        <small class="text-light fw-medium">Today Appointments List</small>
                        @if (Gate::allows('Appointments::add'))
                            <a href="{{ route('appointments.create') }}" class="add-new btn btn-primary mx-3 flot rgith"><i
                                    class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New
                                    Appointment</span></a>
                        @endif
                    </div>
                    @foreach ($appointments as $appointment)
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group">
                                <a href="{{ route('patients.show', $appointment->patient) }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <div class="user-info">
                                                <h6 class="mb-1">{{ $appointment->patient->name }}</h6>
                                                <small>{{ $appointment->estimated_start->diffForHumans() }}</small>
                                                <div class="user-status">
                                                    <span
                                                        class="badge badge-dot bg-success AppointmentStatus-{{ $appointment->status->name }}"></span>
                                                    <small>{{ $appointment->status->toString() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--/ User List Style -->
            </div>
        </div>

        <div class="card-footer">
            <div class="col-md-12">
                {{ $appointments->links('vendor.pagination.clinic') }}
            </div>
        </div>
    </div>
@endsection
