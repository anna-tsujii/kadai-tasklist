@extends('layouts.app')

@section('content')

<h1>id: {{ $task->id }} のタスクを編集する</h1>

    {!! Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'put']) !!}

        {!! Form::label('content', 'タスク:') !!}
        {!! Form::text('content') !!}

        {!! Form::submit('更新する') !!}

    {!! Form::close() !!}
    
@endsection