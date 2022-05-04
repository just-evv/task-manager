@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Edit task</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
        <div class="form-group mb-3">
            {{ Form::label('name', 'Name') }}
            <br>
            {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
        </div>
        {{ Form::submit('Edit', ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}
    </div>

@endsection
