@extends('statamic::layout')
@section('title', __('Executions'))

@section('content')

    <div class="flex items-center mb-6">
        <h1 class="flex-1">{{ __('Executions') }}</h1>
    </div>

    <overseer-executions-listing
        :initial-columns="{{ json_encode($initialColumns) }}"
        :filters="{{ json_encode($filters) }}"
    ></overseer-executions-listing>

@endsection

<style>
    .page-wrapper.max-w-xl {
        max-width: 100% !important;
    }
</style>