@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Create new label')}}</h1>

    {{ Form::model($label, ['route' => 'labels.store', 'class' => "form-group mb-3"]) }}

    {{ Form::bsText('name', 'Name') }}

    {{ Form::bsTextarea('description', 'Description', null, ['rows' => '10', 'cols' => '50']) }}

    {{ Form::submit(__('Create'),  ['class' => 'btn btn-primary mt-3']) }}

    {{ Form::close() }}

@endsection
