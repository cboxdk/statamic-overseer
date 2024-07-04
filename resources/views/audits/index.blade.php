@extends('statamic::layout')
@section('title', __('Audits'))

@section('content')

    <div class="flex items-center mb-6">
        <h1 class="flex-1">{{ __('Audits') }}</h1>
    </div>

    <overseer-audits-listing
        :initial-columns="{{ json_encode($initialColumns) }}"
        :filters="{{ json_encode($filters) }}"
    ></overseer-audits-listing>

@endsection

<style>
    .page-wrapper.max-w-xl {
        max-width: 100% !important;
    }
</style>