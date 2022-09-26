@extends('layouts.app')

@section('content')
        <h1 class="text-3xl font-semibold mb-5">{{__('content.label.edit')}}</h1>

        {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH', 'class' => "w-50"]) }}
        <div class="'flex flex-col">
        {{ Form::bsText('name', __('content.item.name')) }}
        {{ Form::bsTextarea('description', __('content.item.description')) }}
        {{ Form::bsSubmitBtn(__('Update')) }}
        {{ Form::close() }}
        </div>
@endsection
