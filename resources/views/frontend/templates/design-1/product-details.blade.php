@extends('frontend.layouts.app')

@section('title', $product->name . ' - NICK')

@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('product-details') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_details') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_card') }}">
@endpush

@section('content')
    @include($productDetailsView, ['product' => $product])
@endsection

@push('scripts')
    <script>
        function selectSize(el) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');
        }

        function toggleCollapse(header) {
            const content = header.nextElementSibling;
            content.classList.toggle('show');
            const icon = header.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        }

        function showSizeChart() {
            const modal = new bootstrap.Modal(document.getElementById('sizeChartModal'));
            modal.show();
        }

        function checkAvailability() {
            const modal = new bootstrap.Modal(document.getElementById('checkStoreModal'));
            modal.show();
        }

        function checkStoreAvailability() {
            const modal = new bootstrap.Modal(document.getElementById('checkStoreModal'));
            modal.show();
        }

        function addToCart() {
            // Cart module will be connected later.
        }

        function copySKU() {
            const sku = document.getElementById('skuNumber').textContent;
            navigator.clipboard.writeText(sku).then(() => {
                const btn = document.querySelector('.copy-btn i');
                const originalIcon = btn.className;
                btn.className = 'fa-solid fa-check text-success';
                setTimeout(() => {
                    btn.className = originalIcon;
                }, 2000);
            });
        }
        let currentScale = 1;
        let isZoomed = false;

        function changeImage(thumb) {
            const mainImg = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail');
            mainImg.src = thumb.src;
            thumbnails.forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
            resetZoom();
        }

        function zoomImage(e) {
            const container = document.getElementById('mainImageContainer');
            const img = document.getElementById('mainImage');
            if (!isZoomed) {
                container.classList.add('zoomed');
                isZoomed = true;
                currentScale = 2.5;
            }
            const rect = container.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            img.style.transformOrigin = `${x}% ${y}%`;
            img.style.transform = `scale(${currentScale})`;
        }

        function resetZoom() {
            const img = document.getElementById('mainImage');
            const container = document.getElementById('mainImageContainer');
            if (!img || !container) return;
            img.style.transform = 'scale(1)';
            container.classList.remove('zoomed');
            isZoomed = false;
            currentScale = 1;
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                resetZoom();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('input[name="size"]');
            const shopInfo = document.getElementById('shopInfo');
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (shopInfo) {
                        shopInfo.classList.add('show');
                    }
                });
            });
        });
    </script>
@endpush
