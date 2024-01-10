@extends('layouts/layoutMaster')

@section('title', $appointment->name)

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Appointments</span>
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div
                        class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                        <div class="mb-xl-0 mb-4">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                <span class="app-brand-text fw-bold fs-4">
                                    {{ $appointment->patient->name }}
                                </span>
                            </div>
                            <p class="mb-2">
                                Medical History : {{ $appointment->patient->medical_history }}

                            </p>
                            <p class="mb-2">Allergies : {{ $appointment->patient->medical_history }}</p>
                        </div>
                        <div>
                            <h4 class="fw-medium mb-2">PATIENT #{{ $appointment->patient->id }}</h4>
                            <div class="mb-2 pt-1">
                                <span>Status:</span>
                                <span
                                    class="badge AppointmentStatus-{{ $appointment->status->name }}">{{ $appointment->status->toString() }}</span>
                            </div>
                            <div class="pt-1">
                                <span>Creatd By:</span>
                                <span class="fw-medium">{{ $appointment->patient->name }}</span>
                            </div>
                            <div class="pt-1">
                                <span>Assgined To:</span>
                                <span class="fw-medium">{{ $appointment->assignee->name }}</span>
                            </div>
                            <div class="pt-1">
                                <span>Added At:</span>
                                <span class="fw-medium">{{ $appointment->created_at->format('F j, Y H:i') }}</span>
                            </div>
                            <div class="pt-1">
                                <span>Start:</span>
                                <span class="fw-medium">{{ $appointment->estimated_start?->format('F j, Y H:i') }}</span>
                            </div>
                            <div class="pt-1">
                                <span>End:</span>
                                <span class="fw-medium">{{ $appointment->estimated_end?->format('F j, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <div class="row p-sm-3 p-0">
                        <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                            <h5 class="">Diagnosis:</h5>
                            <p class="mb-2">{{ $appointment->diagnosis }}</p>
                            <h5 class="">Procedures:</h5>
                            <p class="mb-2">{{ $appointment->procedures }}</p>
                            <h5 class="">Prescription:</h5>
                            <p class="mb-2">{{ $appointment->prescription }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
