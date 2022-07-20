@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('content.task.edit')}}</h1>

        {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}

        {{ Form::bsText('name', __('content.item.name')) }}

        {{ Form::bsTextarea('description', __('content.item.description'), null , ['rows' => '10']) }}

        {{ Form::bsSelectOne('status_id', __('content.item.status'), $statuses, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectOne('assigned_to_id', __('content.item.assigned_to'), $users, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectMany('labels', __('content.item.labels'), $labels, null,['id' => 'labels']) }}

        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}

@endsection
