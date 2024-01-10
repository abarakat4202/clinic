@extends('layouts/layoutMaster')

@section('title', 'Appointments')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('js/appointments.js') }}"></script>
@endsection

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Appointments Count</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $totalAppointments }}</h3>
                            </div>
                            <small>Total Appointments</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="ti ti-calendar-due ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">

                <div class="col-md-4 mb-4 filter_patients_container">
                    <x-select2 id="filter_patients" multiple="true" title="Patients" placeholder="Select Patient"
                        :options="$options['patients']" :close-on-select=false />
                </div>

                <div class="col-md-4 mb-4 filter_assignees_container">
                    <x-select2 id="filter_assignees" multiple="multiple" title="Assignees" placeholder="Select Assignee"
                        :options="$options['assignees']" :close-on-select=false />
                </div>
                <div class="col-md-4 mb-4 filter_status_container">
                    <x-select2 :options="$options['status']" name="filter_status" title="Status" placeholder="Select Status"
                        template="`<span class='badge
                AppointmentStatus-${option.name}'>${option.text}</span>`"
                        :close-on-select="false" multiple />
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table id="datatable" class="datatable dt-column-search table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Assignee</th>
                        <th>Status</th>
                        <th>Estimated Start</th>
                        <th>Estimated End</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
