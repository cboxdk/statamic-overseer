@extends('statamic::layout')
@section('title', __('Executions'))

@section('content')

    <div class="flex items-center mb-6">
        <h1 class="flex-1">{{ __('View Execution') }}</h1>
    </div>

    <div class="card mb-4">
        <h2 class="mb-4">Data</h2>
        <pre class="text-sm">{{ json_encode($execution, JSON_PRETTY_PRINT) }}</pre>
    </div>
    <div class="card mb-4">
        <h2 class="mb-4">Events</h2>
        <pre class="text-sm">{{ json_encode($execution->events(), JSON_PRETTY_PRINT) }}</pre>
    </div>
    <div class="card mb-4">
        <h2 class="mb-4">Audits</h2>
        <pre class="text-sm">{{ json_encode($execution->audits(), JSON_PRETTY_PRINT) }}</pre>
    </div>

@endsection

<style>
    .page-wrapper.max-w-xl {
        max-width: 100% !important;
    }
</style>