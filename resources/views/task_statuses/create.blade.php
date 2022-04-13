@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Create status</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

{{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    <div class="form-group mb-3">
        {{ Form::label('name', 'Name') }}
        <br>
        {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
    </div>
{{ Form::submit('Create',  ['class' => 'btn btn-primary mt-3']) }}
{{ Form::close() }}

@endsection
