@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="text-3xl font-semibold mb-5">{{__('content.status.edit')}}</h1>

        {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH', 'class' => "w-50"]) }}

        {{ Form::bsText('name', __('content.item.name')) }}

        {{ Form::bsSubmitBtn(__('Update')) }}

    {{ Form::close() }}
    </div>
@endsection
