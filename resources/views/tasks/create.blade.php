@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Create new task')}}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::model($task, ['route' => 'tasks.store', 'class' => "form-group mb-3"]) }}

        {{ Form::label('name', __('Name')) }}
        <br>
        {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
        <br>
        {{ Form::label('description', __('Description')) }}
        <br>
        {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}
        <br>
        {{ Form::label('status_id', __('Status')) }}
        <br>
        {{ Form::select('status_id', $statuses, null, ['class' => 'form-control', 'placeholder' => '----------']) }}
        <br>
        {{ Form::label('assigned_to', __('Assigned to')) }}
        <br>
        {{ Form::select('assigned_to_id', $users, null, ['class' => 'form-control', 'placeholder' => '----------']) }}
        <br>
        {{ Form::label('labels', __('Labels')) }}
        <br>
        {{ Form::select('labels[]', $labels, null, ['multiple' => 'multiple', 'class' => 'form-control', 'placeholder' => '----------']) }}
        <br>
        {{ Form::submit(__('Create'),  ['class' => 'btn btn-primary mt-3']) }}

    {{ Form::close() }}

@endsection
