@extends('layouts.admin')
@section('title', 'Newsletter Subscribers')
@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Newsletter Subscribers',
                ],
            ]"
        />
        <x-admin.alert />
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Newsletter Subscribers</h4>
                        <p class="text-muted mb-0">Manage newsletter subscribers</p>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="newsletterSubscriberSearch"
                            placeholder="Search subscribers..."
                        />
                        <x-admin.sort-dropdown
                            :options="[
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
                <div id="newsletter-subscribers-table">
                    @include('admin.Newsletter.partials.table', [
                        'subscribers' => $subscribers
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function () {
        function loadSubscribers(page = 1) {
            $.ajax({
                url: "{{ route('admin.newsletter-subscribers.index') }}",
                type: "GET",
                data: {
                    search: $('#newsletterSubscriberSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    $('#newsletter-subscribers-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        let searchTimer;
        $('#newsletterSubscriberSearch').on('keyup', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                loadSubscribers();
            }, 400);
        });
        $(document).on('click', '#newsletter-subscribers-pagination a', function (e) {
            e.preventDefault();
            const page = new URL(this.href).searchParams.get('page');
            loadSubscribers(page);
        });
        $(document).on('click', '.sort-dropdown a', function () {
            setTimeout(function () {
                loadSubscribers();
            }, 50);
        });
    });
</script>
@endpush
@endsection