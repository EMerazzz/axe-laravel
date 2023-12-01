@extends('adminlte::page')

@section('title', 'AXE')

@section('content_header')
<blockquote class="custom-blockquote">
    <p class="mb-0">Bienvenidos al sistema AXE ..</p>
    
</blockquote>
@stop

@section('content')


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop