@if (!$isTemplate)
    <div class="form-check mb-4">
        <input
            class="form-check-input"
            type="radio"
            name="design"
            id="use_template_default"
            value=""
            {{ $selectedDesign === null ? 'checked' : '' }}
        >
        <label class="form-check-label" for="use_template_default">
            <span class="fw-semibold">Use Template Default</span>
            <small class="text-muted d-block">
                Use the design provided by the active template.
            </small>
        </label>
    </div>
@endif

@foreach ($templates as $key => $template)
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
            <span class="fw-semibold">{{ $template['label'] }}</span>

            @if (!$isTemplate && $key === $activeTemplate)
                <span class="badge bg-success ms-2">Active Template</span>
            @endif
        </label>
    </div>
@endforeach