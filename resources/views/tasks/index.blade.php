@extends('layouts.app')

@section('content')

    <h1>タスク一覧</h1>
    
    @if(count($tasks) > 0)
        <table class="tabele table-striped">
            <thead>
                <tr>
                    <th>id</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                    <td>{{ $task->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- タスク制作ページへのリンク --}}
    {!! link_to_route('tasks.create', '新規タスクの追加', [], ['class' => 'btn btn-primary']) !!}


@endsection