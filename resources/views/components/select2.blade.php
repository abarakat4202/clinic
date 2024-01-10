@php
    $id = $id ?? $name;

@endphp

@push('scripts')
    <script>
        const {{ $id }}SelectEl = document.querySelector('#{{ $id }}');
        const {{ $id }}Selected = @json(\Arr::wrap($selected ?? []));
        const {{ $id }}Options = @json($options)
            .map(function(option) {
                return {
                    ...option,
                    id: option.value || option.id,
                    text: option.text || option.name,
                    selected: {{ $id }}Selected.includes(option.value || option.id),
                };
            })
        {{ $id }}Options.unshift({
            id: '',
            text: ''
        })

        $({{ $id }}SelectEl).wrap('<div class="position-relative"></div>').select2({
            data: {{ $id }}Options,
            closeOnSelect: {{ isset($closeOnSelect) ? var_export($closeOnSelect) : true }},
            dropdownParent: $({{ $id }}SelectEl).parent(),
            readonly: {{ var_export($readonly ?? false) }},
            @if (!empty($template))
                templateResult: (option) => {!! $template !!},
                templateSelection: (option) => {!! $template !!},
                escapeMarkup: function(es) {
                    return es;
                }
            @endif

        });
    </script>
@endpush

<label for="{{ $id }}" class="form-label">{{ $title ?? ($placeholder ?? 'select value') }}</label>
<select id="{{ $id }}" name="{{ $name ?? $id }}"
    data-placeholder="{{ $placeholder ?? ($title ?? 'select value') }}" class="form-control"
    {{ !empty($multiple) ? 'multiple' : '' }} {{ !empty($required) ? 'required' : '' }} @readonly($readonly ?? false)>
    {{-- <option value=""></option>
    @foreach ($options as $option)
        <option value="{{ $option['value'] ?? $option['id'] }}"
            {{ isset($selected) && $selected == ($option['value'] ?? $option['id']) ? 'selected' : '' }}>
            {{ $option['text'] ?? $option->toString() }}</option>
    @endforeach --}}
</select>
<span class="error"> @error($name ?? $id)
        {{ $message }}
    @enderror
