@foreach ($designs as $key => $label)
    <div class="form-check mb-3">
        <input
            class="form-check-input"
            type="radio"
            name="design"
            id="design_{{ $key }}"
            value="{{ $key }}"
            {{ $selectedDesign === $key ? 'checked' : '' }}
        >
        <label class="form-check-label" for="design_{{ $key }}">
            {{ $label }}
        </label>
    </div>
@endforeach