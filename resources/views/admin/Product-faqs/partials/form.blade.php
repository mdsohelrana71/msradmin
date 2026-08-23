<div class="row">
    {{-- Products --}}
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="product_ids">
                Products <span class="text-danger">*</span>
            </label>
            <select
                name="product_ids[]"
                id="product_ids"
                class="form-control select2 @error('product_ids') is-invalid @enderror"
                multiple
                required
            >
                @php
                    $selectedProducts = old(
                        'product_ids',
                        $faq?->products?->pluck('id')->toArray() ?? []
                    );
                @endphp
                @foreach ($products as $product)
                    <option
                        value="{{ $product->id }}"
                        @selected(in_array($product->id, $selectedProducts))
                    >
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_ids')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            @error('product_ids.*')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <small class="text-muted">
                Select one or multiple products for this FAQ.
            </small>
        </div>
    </div>

    {{-- Question --}}
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="question">
                Question <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="question"
                id="question"
                class="form-control @error('question') is-invalid @enderror"
                placeholder="Enter frequently asked question"
                value="{{ old('question', $faq->question ?? '') }}"
                required
            >
            @error('question')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Answer --}}
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="answer">
                Answer <span class="text-danger">*</span>
            </label>
            <textarea
                name="answer"
                id="answer"
                rows="6"
                class="form-control @error('answer') is-invalid @enderror"
                placeholder="Enter FAQ answer"
                required
            >{{ old('answer', $faq->answer ?? '') }}</textarea>
            @error('answer')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Status --}}
    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="status">
                Status <span class="text-danger">*</span>
            </label>
            <select
                name="status"
                id="status"
                class="form-control @error('status') is-invalid @enderror"
                required
            >
                <option
                    value="1"
                    @selected(old('status', $faq->status ?? 1) == 1)
                >
                    Active
                </option>
                <option
                    value="0"
                    @selected(old('status', $faq->status ?? 1) == 0)
                >
                    Inactive
                </option>
            </select>
            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Sort Order --}}
    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="sort_order">
                Sort Order
            </label>
            <input
                type="number"
                name="sort_order"
                id="sort_order"
                min="0"
                class="form-control @error('sort_order') is-invalid @enderror"
                placeholder="0"
                value="{{ old('sort_order', $faq->sort_order ?? 0) }}"
            >
            @error('sort_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

@push('styles')
<style>
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ebedf2;
        border-radius: 4px;
        padding: 3px 5px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-top: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
    function initializeProductSelect() {
        const productSelect = $('#product_ids');

        if (!productSelect.length) {
            return;
        }

        if (productSelect.hasClass('select2-hidden-accessible')) {
            productSelect.select2('destroy');
        }

        productSelect.select2({
            placeholder: 'Select products...',
            allowClear: true,
            width: '100%'
        });
    }

    $(document).ready(function () {
        initializeProductSelect();
    });
</script>
@endpush