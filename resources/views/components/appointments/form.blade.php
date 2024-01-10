@push('scripts')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $('form .form-control, form .form-check-input, form select').on('invalid', function() {
            $parent = $(this).parents('.col-md-6')
            $parent.find('.error').text(
                this.validationMessage
            );
        }).on('keyup', function() {
            $(this).parents('.col-md-6').find('.error').empty()
        }).on('change', function() {
            $(this).parents('.col-md-6').find('.error').empty()
        })
    </script>
@endpush

<form id="appointmentForm"
    action="{{ empty($appointment) ? route('appointments.store') : route('appointments.update', $appointment) }}"
    method="POST" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" autocomplete="off">
    @csrf
    @if (!empty($appointment))
        @method('PATCH')
    @endif
    <div class="col-md-6">
        <x-select2 name="patient" title="Patient" placeholder="Select Patient" :options="$options['patients']" required="true"
            :selected="old('patient') ?? ($patient->id ?? null)" :readonly="!empty($patient)" />
        <span class="error"> @error('patient')
                {{ $message }}
            @enderror
        </span>
    </div>
    <div class="col-md-6">
        <x-select2 name="assignee" title="Assignee (Doctor)" placeholder="Select Doctor" :options="$options['assignees']"
            required="true" :selected="old('assignee') ?? ($appointment->assignee_id ?? null)" />
        <span class="error"> @error('assignee')
                {{ $message }}
            @enderror
        </span>
    </div>
    <div class="col-md-6">
        <label for="datetime" class="form-label">Appointment Date</label>
        <input type="datetime-local" min="{{ now()->addMinutes(10)->format('Y-m-d\TH:i') }}" name="appointment_date"
            class="form-control" placeholder="YYYY-MM-DD HH:MM" id="datetime"
            value="{{ old('appointment_date', $appointment->estimated_start ?? null) }}" required />
        <span class="error"> @error('estimated_start')
                {{ $message }}
            @enderror
        </span>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="formValidationName">Duration (in minutes)</label>
        <input type="numeric" id="formValidationName" class="form-control" placeholder="5" min="5" max="120"
            name="duration" value="{{ old('duration', $appointment->estimated_duration ?? null) }}" required>
        <span class="error"> @error('duration')
                {{ $message }}
            @enderror
        </span>
    </div>
    @if (!empty($appointment))
        <hr class="mt-2">
        <div class="col-md-6">
            <label class="form-label">Diagnosis</label>
            <textarea class="form-control" name="diagnosis" rows="7" minlength="5" required>{{ old('diagnosis', $appointment->diagnosis ?? '') }}</textarea>
            <span class="error"> @error('diagnosis')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Procedures</label>
            <textarea class="form-control" name="procedures" rows="7">{{ old('procedures', $appointment->procedures ?? '') }}</textarea>
            <span class="error"> @error('procedures')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Prescription</label>
            <textarea class="form-control" name="prescription" rows="7" minlength="5" required>{{ old('prescription', $appointment->prescription ?? '') }}</textarea>
            <span class="error"> @error('prescription')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <x-select2 :options="$options['status']" name="status" title="Status" placeholder="Select Status"
                template="`<span class='badge
                AppointmentStatus-${option.name}'>${option.text}</span>`"
                :close-on-select="true" :selected="old('status') ?? ($appointment->status->value ?? null)" />
        </div>
    @endif
    <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Submit</button>
        @empty($isModal)
            <button type="reset" class="btn btn-label-secondary" onclick="history.back()">Cancel</button>
        @else
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
        @endempty
    </div>
</form>
