@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit task')}}</h1>

        {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}

        {{ Form::label('name', __('Name')) }}
        <br>
        {{ Form::text('name', $value = null , ['class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null)]) }}
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        <br>
        {{ Form::label('description', __('Description')) }}
        <br>
        {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}
        <br>
        {{ Form::label('status_id', __('Status')) }}
        <br>
        {{ Form::select('status_id', $statuses, null, ['class' => 'form-control'. ($errors->has('status_id') ? ' is-invalid' : null), 'placeholder' => '----------']) }}
                @error('status_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        <br>
        {{ Form::label('assigned_to', __('Assigned to')) }}
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
