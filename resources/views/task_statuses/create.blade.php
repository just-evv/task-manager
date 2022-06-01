@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Create new status')}}</h1>

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
        {{ Form::label('name', __('Name')) }}
        <br>
        {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
    </div>
{{ Form::submit(__('Create'),  ['class' => 'btn btn-primary mt-3']) }}
{{ Form::close() }}

@endsection
