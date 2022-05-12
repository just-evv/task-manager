@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Task review: {{ $task->name }}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>Name: {{ $task->name }}</p>
    <p>Status: {{ $task->status->name }}</p>
    <p>Description: {{ $task->description }}</p>

@endsection
