@extends('layouts/layoutMaster')

@section('title', empty($patient) ? 'Add Patient' : 'Edit Patient')


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

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $('form .form-control, form .form-check-input, form select').on('invalid', function() {
            $parent = $(this).parents('.col-md-6')
            $parent.find('.error').text(
                this.validationMessage
            );
        }).on('keyup', function() {
            $(this).parents('.col-md-6').find('.error').empty()
        })
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Patients /</span>
        {{ empty($patient) ? 'Add Patient' : 'Edit Patient' }}
    </h4>

    <!-- Basic Layout -->
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">{{ $patient->name ?? 'Patient' }}</h5>
                <div class="card-body">

                    <form id="patientForm"
                        action="{{ empty($patient) ? route('patients.store') : route('patients.update', $patient) }}"
                        method="POST" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" autocomplete="off">
                        @csrf
                        @if (!empty($patient))
                            @method('PATCH')
                        @endif

                        <div class="col-12">
                            <h5 class="">1. Basic Info</h5>
                            <hr class="mt-0" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="formValidationName">Full Name</label>
                            <input type="text" id="formValidationName" class="form-control" placeholder="John Doe"
                                name="name" value="{{ old('name', $patient->name ?? null) }}" required>
                            <span class="error"> @error('name') {{ $message }} @endif </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="formValidationPhone">Phone</label>
                            <input value="{{ old('phone', $patient->phone ?? null) }}" type="tel"
                                id="formValidationPhone" class="form-control" placeholder="0109 881 1293" autocomplete="off"
                                aria-required="true" hiddenInput="phone" intlTelInput required />
                            <span class="error"> @error('phone') {{ $message }} @endif </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="formValidationDob">Birth Date</label>
                            <input type="date" class="form-control flatpickr-validation" id="formValidationDob"
                                name="birth_date"
                                value="{{ old('birth_date', !empty($patient) ? $patient->birth_date->format('Y-m-d') : '') }}"
                                max='{{ today() }}' required />
                            <span class="error"> @error('birth_date') {{ $message }} @endif
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <div class="form-check custom mb-2">
                                <input type="radio" id="formValidationGender" name="gender" class="form-check-input"
                                    value="{{ $options['genders'][0]->value }}" @checked((old('gender') ?? ($patient->gender->value ?? null)) == $options['genders'][0]->value) required />
                                <label class="form-check-label"
                                    for="formValidationGender">{{ $options['genders'][0]->toString() }}</label>
                            </div>

                            <div class="form-check custom">
                                <input type="radio" id="formValidationGender2" name="gender" class="form-check-input"
                                    value="{{ $options['genders'][1]->value }}" @checked((old('gender') ?? ($patient->gender->value ?? null)) == $options['genders'][1]->value) required />
                                <label class="form-check-label"
                                    for="formValidationGender2">{{ $options['genders'][1]->toString() }}</label>
                            </div>
                            <span class="error"> @error('gender') {{ $message }} @endif </span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="formValidationTech">Address</label>
                            <input class="form-control " type="text" id="formValidationTech"
                                value="{{ old('address', $patient->address ?? '') }}" autocomplete="off" name="address" />
                            <span class="error"> @error('address') {{ $message }} @endif </span>
                        </div>

                        <!-- Medical Info -->
                        <div class="col-12">
                            <h5 class="mt-2 ">2. Medical Info</h5>
                            <hr class="mt-0" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Medical History</label>
                            <textarea class="form-control" name="medical_history" rows="7">{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
                            <span class="error"> @error('medical_history') {{ $message }} @endif
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Allergies</label>
                            <textarea class="form-control" name="allergies" rows="7">{{ old('allergies', $patient->allergies ?? '') }}</textarea>
                            <span class="error"> @error('allergies') {{ $message }} @endif
                            </span>
                        </div>
                        <!-- Emergency Info -->
                        <div class="col-12">
                            <h5 class="mt-2 ">3. Emergency Contact</h5>
                            <hr class="mt-0" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="formValidationEmergencyName">Emergency Contact Name</label>
                            <input type="text" id="formValidationEmergencyName" class="form-control"
                                placeholder="John Doe" name="emergency_name"
                                value="{{ old('emergency_name', $patient->name ?? null) }}"
                                value="{{ old('emergency_name', $patient->emergency_name ?? '') }}">
                            <span class="error"> @error('emergency_name') {{ $message }} @endif
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="formValidationEmergencyPhone">Emergency Contact Phone</label>
                            <input value="{{ old('emergency_phone', $patient->emergency_phone ?? null) }}" type="tel"
                                id="formValidationEmergencyPhone" class="form-control" placeholder="0109 881 1293"
                                autocomplete="off" aria-required="true" hiddenInput="emergency_phone" intlTelInput
                                value="{{ old('emergency_phone', $patient->emergency_phone ?? '') }}" />
                            <span class="error"> @error('emergency_phone') {{ $message }} @endif
                            </span>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-label-secondary"
                                onclick="history.back()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /FormValidation -->
    </div>
@endsection
