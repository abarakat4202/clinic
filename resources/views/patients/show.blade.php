@extends('layouts/layoutMaster')

@section('title', $patient->name)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/intlTelInput/intlTelInput.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/intlTelInput/intlTelInput.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-international-telephone-input/index.min.js') }}">
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Patients /</span> {{ $patient->name }}
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header-banner">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ $patient->name }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item d-flex gap-1">
                                        <a href="tel:{{ $patient->phone }}"><i class="ti ti-phone"></i>
                                            {{ $patient->phone }}</a>
                                    </li>
                                    <li class="list-inline-item d-flex gap-1">
                                        <a target="_blank"
                                            href="https://api.whatsapp.com/send?phone={{ str_replace('+', '00', $patient->phone) }}&text="><i
                                                class="ti ti-brand-whatsapp"></i> {{ $patient->phone }}</a>
                                    </li>
                                    @if ($incomingAppointment)
                                        <li class="list-inline-item d-flex gap-1">
                                            <i class="ti ti-calendar"></i> Incoming Appointment :
                                            {{ $incomingAppointment->estimated_start->format('F j, Y H:i') }}
                                        </li>
                                    @endif
                                </ul>

                                <div class="mt-3">
                                    @if (Gate::allows('Patients::edit'))
                                        <a href="{{ route('patients.edit', $patient) }}"
                                            class="btn btn-sm btn-primary waves-effect waves-light">
                                            Edit Patient
                                        </a>
                                    @endif
                                    @if (Gate::allows('Appointments::add') && empty($incomingAppointment))
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#appointmentModal">
                                            Add Appointment
                                        </button>
                                    @elseif(Gate::allows('Appointments::edit') && !empty($incomingAppointment))
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#appointmentModal">
                                            Update Appointment
                                        </button>
                                    @endif
                                    <!-- Appointment Modal -->
                                    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                                            <div class="modal-content p-3 p-md-5">
                                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <div class="modal-body">
                                                    <div class="text-center mb-4">
                                                        <h3 class="role-title mb-2">Update Appointment</h3>
                                                    </div>
                                                    <x-appointments.form :options="$options" :patient="$patient"
                                                        :appointment="$incomingAppointment ?? null" isModal="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / Appointment Modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-4">
                <div class="card-body">
                    <small class="card-text text-uppercase">Patient Details</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><span class="fw-medium mx-2 text-heading">
                                Name:</span> <span>{{ $patient->name }}</span></li>
                        <li class="d-flex align-items-center mb-3"><span class="fw-medium mx-2 text-heading">Gender:</span>
                            <span>{{ $patient->gender->toString() }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3"><span class="fw-medium mx-2 text-heading">Age:</span>
                            <span>{{ $patient->age }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3"><span class="fw-medium mx-2 text-heading">Birth
                                Date:</span>
                            <span>{{ $patient->birth_date->toDateString() }}</span>
                        </li>
                    </ul>
                    <small class="card-text text-uppercase">emergency</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><span class="fw-medium mx-2 text-heading">Emergency
                                Name:</span>
                            <span>{{ $patient->emergency_name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3"><span class="fw-medium mx-2 text-heading">Emergency
                                Phone:</span>
                            <span>{{ $patient->emergency_phone }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/ About User -->
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7">
            <!-- Activity Timeline -->
            <div class="card mb-4">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Medical History</h5>
                    {{ $patient->medical_history }}
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Allergies</h5>
                    {{ $patient->allergies }}
                </div>
            </div>
            <div class="card card-action mb-4">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Appointments History</h5>
                </div>
                <div class="card-body pb-0">
                    <ul class="timeline ms-1 mb-0">
                        @foreach ($patient->appointments as $appointment)
                            <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point AppointmentStatus-{{ $appointment->status->name }}"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header">
                                        <h6 class="mb-0"><span
                                                class="badge AppointmentStatus-{{ $appointment->status->name }}">{{ $appointment->status->toString() }}</span>
                                        </h6>
                                        <h6 class="mb-0">{{ $appointment->assignee->name }}</h6>
                                        <small
                                            class="text-muted">{{ $appointment->estimated_start->format('F j, Y H:i') }}</small>
                                    </div>
                                    <small class="text-muted">Diagnosis</small>
                                    <p class="mb-2">{{ $appointment->diagnosis }}</p>
                                    <small class="text-muted">Procedures</small>
                                    <p class="mb-2">{{ $appointment->procedures }}</p>
                                    <small class="text-muted">Prescription</small>
                                    <p class="mb-2">{{ $appointment->prescription }}</p>
                                    <button class="btn btn-outline-primary btn-sm waves-effect" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#appointmentDetails-{{ $appointment->id }}" aria-expanded="true"
                                        aria-controls="appointmentDetails-{{ $appointment->id }}">
                                        Show Details
                                    </button>
                                    <div class="collapse" id="appointmentDetails-{{ $appointment->id }}" style="">
                                        <ul class="list-group list-group-flush mt-3">
                                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span>Creator : <span
                                                        class="fw-medium">{{ $appointment->creator->name }}</span></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span>Estimated Start : <span
                                                        class="fw-medium">{{ $appointment->estimated_start?->format('F j, Y H:i') }}</span></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                                <span>Estimated End : <span
                                                        class="fw-medium">{{ $appointment->estimated_end?->format('F j, Y H:i') }}</span></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--/ Activity Timeline -->
        </div>
    </div>
@endsection
