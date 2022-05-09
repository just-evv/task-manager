@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Create task</h1>

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

        {{ Form::label('name', 'Name') }}
        <br>
        {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
        <br>
        {{ Form::label('description', 'Description') }}
        <br>
        {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}
        <br>
        {{ Form::label('status_id', 'Status') }}
        <br>
        {{ Form::select('status_id', $statuses, null, ['class' => 'form-control']) }}
        <br>
        {{ Form::label('assigned_to', 'Assigned to') }}
        <br>
        {{ Form::select('assigned_to_id', $allUsers, null, ['class' => 'form-control', 'placeholder' => '----------']) }}
        <br>
        {{ Form::submit('Create',  ['class' => 'btn btn-primary mt-3']) }}

    {{ Form::close() }}

@endsection
