@extends('statamic::layout')
@section('title', __('Events'))

@section('content')

    <div class="flex items-center mb-6">
        <h1 class="flex-1">{{ __('Events') }}</h1>
    </div>

    <overseer-events-listing
        :initial-columns="{{ json_encode($initialColumns) }}"
        :filters="{{ json_encode($filters) }}"
    ></overseer-events-listing>

@endsection

<style>
    .page-wrapper.max-w-xl {
        max-width: 100% !important;
    }
</style>