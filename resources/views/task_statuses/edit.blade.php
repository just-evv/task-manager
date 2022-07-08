@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit status')}}</h1>

    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}

        {{ Form::bsText('name', 'Name') }}

        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3']) }}

    {{ Form::close() }}
@endsection
