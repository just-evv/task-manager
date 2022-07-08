@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Create new task')}}</h1>

    {{ Form::model($task, ['route' => 'tasks.store', 'class' => "form-group mb-3"]) }}

        {{ Form::bsText('name', 'Name') }}

        {{ Form::bsTextarea('description', 'Description', null , ['rows' => '10']) }}

        {{ Form::bsSelectOne('status_id', 'Status', $statuses, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectOne('assigned_to_id', 'Assigned to', $users, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectMany('labels', 'Labels', $labels, null,['id' => 'labels']) }}

        {{ Form::submit(__('Create'),  ['class' => 'btn btn-primary mt-3']) }}

    {{ Form::close() }}

@endsection
