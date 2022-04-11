@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Задачи</h1>
    <div class="d-flex mb-3">
        <div>
                <!-- Form -->
        </div>
    </div>

    <table class="table me-2">
        <thead>
        <tr>
            <th>ID</th>
            <th>Статус</th>
            <th>Имя</th>
            <th>Автор</th>
            <th>Исполнитель</th>
            <th>Дата создания</th>
        </tr>
        </thead>
        <tr>
            <td></td>
            <td></td>
            <td>
                <a class="text-decoration-none" href=" { route('') } ">
                </a>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
@endsection
