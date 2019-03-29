@extends('adminlte::page')

@section('title','Cadastrar nova categoria')

@section('content_header')
<h1>Cadastrar nova categoria</h1>

@stop

@section('content')
<div class="content row">
    <div class="box box-success">
        <div class="box-body">
            
            @include('admin.includes.alerts')            
            
            <form action="{{ route('categories.store') }}" method="POST">
                @include('admin.categories._partials.form')
            </form>
        </div>
    </div>
</div>
@stop


