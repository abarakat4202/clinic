@push('scripts')
    <script>
        const FilterStatusEl = document.querySelector('#filter_status');
        const status = @js($options);

        $(FilterStatusEl).wrap('<div class="position-relative"></div>').select2({
            data: status,
            closeOnSelect: false,
            dropdownParent: $(FilterStatusEl).parent(),
            templateResult: (status) =>
                `<span class="badge AppointmentStatus-${status.name}">${status.text}</span>`,
            templateSelection: (status) =>
                `<span class="badge AppointmentStatus-${status.name}">${status.text}</span>`,
            escapeMarkup: function(es) {
                return es;
            }
        });
    </script>
@endpush

<label for="filter_status" class="form-label">Status</label>
<select id="filter_status" name="{{ $name ?? ($id ?? 'status') }}"
    data-placeholder="{{ $placeholder ?? ($title ?? 'select Status') }}" class="form-control"
    {{ !empty($multiple) ? 'multiple' : '' }} {{ !empty($required) ? 'required' : '' }}>
    <option value=""></option>
    @foreach ($options as $option)
        <option value="{{ $option['value'] ?? $option['id'] }}"
            {{ isset($selected) && $selected == ($option['value'] ?? $option['id']) ? 'selected' : '' }}>
            {{ $option['text'] ?? $option->toString() }}</option>
    @endforeach
</select>
