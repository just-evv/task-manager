@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
    <h1 class="text-3xl font-semibold mb-5">{{__('content.label.create')}}</h1>

    {{ Form::model($label, ['route' => 'labels.store', 'class' => "w-50"]) }}

    {{ Form::bsText('name', __('content.item.name')) }}

    {{ Form::bsTextarea('description',  __('content.item.description')) }}

        {{ Form::bsSubmitBtn(__('Create')) }}

    {{ Form::close() }}
</div>
@endsection
