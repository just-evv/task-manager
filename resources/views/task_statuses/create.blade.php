@extends('layouts.app')

@section('content')
        <h1 class="text-3xl font-semibold mb-5">{{__('content.status.create')}}</h1>

    {{ Form::model($taskStatus, ['route' => 'task_statuses.store', 'class' => "w-50"]) }}
        {{ Form::bsText('name', __('content.item.name')) }}

    {{ Form::bsSubmitBtn(__('Create')) }}
    {{ Form::close() }}
@endsection
