@extends('layouts.admin')

@section('title', 'Sliders')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Sliders',
                ],
            ]"
            :action="[
                'label' => 'Add Slider',
                'url' => route('admin.sliders.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'sliders.create',
            ]"
        />
        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Sliders</h4>
                        <p class="text-muted mb-0">Manage all sliders</p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="sliderSearch"
                            placeholder="Search sliders..."
                        />
                        <x-admin.sort-dropdown
                            :options="[
                                'a_z' => 'A to Z',
                                'z_a' => 'Z to A',
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="sliders-table">
                    @include('admin.Sliders.partials.table', [
                        'sliders' => $sliders
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadSliders(page = 1) {
            $.ajax({
                url: "{{ route('admin.sliders.index') }}",
                type: "GET",
                data: {
                    search: $('#sliderSearch').val(),
                    sort: $('.sort-dropdown').val(),
                    page: page
                },
                success: function (response) {
                    $('#sliders-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#sliderSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadSliders();
            }, 400);
        });

        $(document).on('click', '#sliders-pagination a', function (e) {
            e.preventDefault();

            const page = new URL(this.href).searchParams.get('page');

            loadSliders(page);
        });
    });

    function confirmDelete(id) {
        const form = document.querySelector(`form[action$="/sliders/${id}"]`);
        const modal = document.getElementById('deleteSliderModal');

        if (!modal || !form) return;

        modal.querySelector('form').action = form.action;
        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
@endsection