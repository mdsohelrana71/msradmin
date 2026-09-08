@extends('frontend.layouts.app')
@section('title', $blog->title)
@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('blog-details') }}">
@endpush
@section('content')
    @include($blogDetailsView, ['blog' => $blog])
@endsection
