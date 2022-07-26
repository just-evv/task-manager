@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('content.status.create')}}</h1>

    {{ Form::model($taskStatus, ['route' => 'task_statuses.store', 'class' => "form-group mb-3"]) }}
        {{ Form::bsText('name', __('content.item.name')) }}

        {{ Form::submit(__('Create'),  ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}

@endsection
