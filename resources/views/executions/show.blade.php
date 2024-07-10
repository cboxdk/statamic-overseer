@extends('statamic::layout')
@section('title', __('Executions'))

@section('content')

    <div class="flex items-center mb-6">
        <h1 class="flex-1">{{ __('View Execution') }}</h1>
    </div>

    <overseer-executions-view
        :execution="{{ json_encode($execution) }}"
    ></overseer-executions-view>

@endsection

<style>
    .page-wrapper.max-w-xl {
        max-width: 100% !important;
    }
</style>