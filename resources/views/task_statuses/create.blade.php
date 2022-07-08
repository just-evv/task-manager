@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Create new status')}}</h1>

    {{ Form::model($taskStatus, ['route' => 'task_statuses.store', 'class' => "form-group mb-3"]) }}
        {{ Form::bsText('name', 'Name') }}

        {{ Form::submit(__('Create'),  ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}

@endsection
