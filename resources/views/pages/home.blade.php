@extends('layouts.app')

@section('title', __('messages.meta_title'))

@section('meta_description', __('messages.meta_description'))

@push('head_scripts')
    @include('partials.json-ld')
@endpush

@section('content')
    @include('partials.sections.hero')
    @include('partials.sections.booking-form')
    @include('partials.sections.services')
    @include('partials.sections.fleet')
    @include('partials.sections.advantages')
    @include('partials.sections.area')
    @include('partials.sections.how-to-order')
    @include('partials.sections.faq')
    @include('partials.sections.final-cta')
@endsection
