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
    <p>Иногда вам нужно вывести переменную, которая может быть определена, а может быть нет. 
    </p>
    Например:

    {{ isset($name) ? $name : 'Default' }}
<p>
    Но вам не обязательно писать тернарный оператор, Blade позволяет записать это короче:
</p>
    {{ $name or 'Default' }}
    @{{ Этот текст не будет обрабатываться шаблонизатором Blade }}

        @if (count($records) === 1)
            Здесь есть одна запись!
        @elseif (count($records) > 1)
            Здесь есть много записей!
        @else
            Здесь нет записей!
        @endif

        @unless (Auth::check())
            Вы не вошли в систему.
        @endunless
@stop
