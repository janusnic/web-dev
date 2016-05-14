@extends('layouts.master')

@section('title', 'Заголовок страницы')

@section('sidebar')

    @parent

    <p>Этот элемент будет добавлен к главному сайдбару.</p>
    Текущее время эпохи UNIX: {{ time() }}.
@stop

@section('content')
    <div class="content">
                <div class="title">Laravel 5</div>
    </div>

    <p>Это - содержимое страницы.</p>
   
@stop
