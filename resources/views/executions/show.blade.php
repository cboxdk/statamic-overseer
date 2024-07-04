@extends('statamic::layout')
@section('title', __('Executions'))

@section('content')

    <div class="flex items-center mb-6">
        <h1 class="flex-1">{{ __('View Execution') }}</h1>
    </div>

    <pre class="card text-sm">{{ json_encode($execution, JSON_PRETTY_PRINT) }}</pre>

@endsection

<style>
    .page-wrapper.max-w-xl {
        max-width: 100% !important;
    }
</style>