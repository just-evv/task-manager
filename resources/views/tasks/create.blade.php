@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-semibold mb-5">{{__('content.task.create')}}</h1>

    {{ Form::model($task, ['route' => 'tasks.store', 'class' => "w-50"]) }}

        {{ Form::bsText('name', __('content.item.name')) }}

        {{ Form::bsTextarea('description', __('content.item.description')) }}

        {{ Form::bsSelectOne('status_id', __('content.item.status'), $statuses, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectOne('assigned_to_id', __('content.item.assigned_to'), $users, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectMany('labels', __('content.item.labels'), $labels, null, ['id' => 'labels', 'placeholder' => '']) }}

        {{ Form::bsSubmitBtn(__('Create')) }}

    {{ Form::close() }}
    </div>
@endsection
