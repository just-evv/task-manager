@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit status')}}</h1>

    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}
        {{ Form::label('name', __('Name')) }}
        <br>
        {{ Form::text('name', $value = null , ['class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null)]) }}
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}
@endsection
