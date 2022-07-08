@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit task')}}</h1>

        {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}

        {{ Form::bsText('name', 'Name') }}

        {{ Form::bsTextarea('description', 'Description', null , ['rows' => '10']) }}

        {{ Form::bsSelectOne('status_id', 'Status', $statuses, null, ['placeholder' => '----------']) }}

        {{ Form::bsSelectOne('assigned_to_id', 'Assigned to', $users, null, ['placeholder' => '----------']) }}
        <br>
        {{ Form::select('assigned_to_id', $allUsers, null, ['class' => 'form-control', 'placeholder' => '----------']) }}
        <br>
        {{ Form::label('labels', __('Labels')) }}
        <br>
        {{ Form::select('labels[]', $labels, null, ['multiple' => 'multiple', 'class' => 'form-control']) }}
        <br>
        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}

@endsection
