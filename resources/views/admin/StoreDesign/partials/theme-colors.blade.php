@extends('layouts.admin')

@section('title', 'Theme Colors')

@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Store Design',
                    'url' => route('admin.store-designs.index'),
                ],
                [
                    'label' => 'Theme Colors',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title mb-1">Theme Colors</h4>
                                <p class="text-muted mb-0">
                                    Manage the global colors used across your storefront.
                                </p>
                            </div>

                            <a
                                href="{{ route('admin.store-designs.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                <i class="fa fa-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>

                    <form
                        action="{{ route('admin.theme-colors.update', 'theme') }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primary Color</label>

                                        <div class="theme-color-picker">
                                            <label
                                                class="color-swatch"
                                                style="background-color: {{ old('theme_primary_color', $colors['theme_primary_color']) }};"
                                            >
                                                <input
                                                    type="color"
                                                    name="theme_primary_color"
                                                    value="{{ old('theme_primary_color', $colors['theme_primary_color']) }}"
                                                >
                                            </label>

                                            <input
                                                type="text"
                                                value="{{ old('theme_primary_color', $colors['theme_primary_color']) }}"
                                                class="form-control hex-value"
                                            >
                                        </div>

                                        @error('theme_primary_color')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Secondary Color</label>

                                        <div class="theme-color-picker">
                                            <label
                                                class="color-swatch"
                                                style="background-color: {{ old('theme_secondary_color', $colors['theme_secondary_color']) }};"
                                            >
                                                <input
                                                    type="color"
                                                    name="theme_secondary_color"
                                                    value="{{ old('theme_secondary_color', $colors['theme_secondary_color']) }}"
                                                >
                                            </label>

                                            <input
                                                type="text"
                                                value="{{ old('theme_secondary_color', $colors['theme_secondary_color']) }}"
                                                class="form-control hex-value"
                                            >
                                        </div>

                                        @error('theme_secondary_color')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Light Color</label>

                                        <div class="theme-color-picker">
                                            <label
                                                class="color-swatch"
                                                style="background-color: {{ old('theme_light_color', $colors['theme_light_color']) }};"
                                            >
                                                <input
                                                    type="color"
                                                    name="theme_light_color"
                                                    value="{{ old('theme_light_color', $colors['theme_light_color']) }}"
                                                >
                                            </label>

                                            <input
                                                type="text"
                                                value="{{ old('theme_light_color', $colors['theme_light_color']) }}"
                                                class="form-control hex-value"
                                            >
                                        </div>

                                        @error('theme_light_color')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <x-admin.form-actions
                                submitText="Save Colors"
                                :cancelUrl="route('admin.store-designs.index')"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .theme-color-picker {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .color-swatch {
        width: 52px;
        height: 52px;
        flex: 0 0 52px;
        display: block;
        border-radius: 50%;
        border: 3px solid #fff;
        outline: 1px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
        cursor: pointer;
        transition: .2s;
    }

    .color-swatch:hover {
        transform: scale(1.08);
    }

    .color-swatch input[type="color"] {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .hex-value {
        max-width: 150px;
        font-family: monospace;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.theme-color-picker').forEach(function (picker) {
        const colorInput = picker.querySelector('input[type="color"]');
        const swatch = picker.querySelector('.color-swatch');
        const hexInput = picker.querySelector('.hex-value');

        hexInput.addEventListener('focus', function () {
            this.select();
        });

        hexInput.addEventListener('input', function () {
            let value = this.value.trim();

            if (!value.startsWith('#')) {
                value = '#' + value;
            }

            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                colorInput.value = value;
                swatch.style.backgroundColor = value;
            }
        });

        colorInput.addEventListener('input', function () {
            swatch.style.backgroundColor = this.value;
            hexInput.value = this.value;
        });

        swatch.addEventListener('click', function () {
            colorInput.click();
        });
    });
</script>
@endpush