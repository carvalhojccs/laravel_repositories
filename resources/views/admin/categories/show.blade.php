@extends('adminlte::page')

@section('title','Detalhes da Categoria')

@section('content_header')
<h1>Categoria: {{ $category->title }}</h1>

@stop

@section('content')
<div class="content row">
    <div class="box box-success">
        <div class="box-body">
            <p><strong>ID:</strong>{{ $category->id }}</p>
            <p><strong>TÍTULO:</strong>{{ $category->title }}</p>
            <p><strong>URL:</strong>{{ $category->url }}</p>
            <p><strong>DESCRIÇÃO:</strong>{{ $category->description }}</p>
            
            <hr>
            
            <form action="{{ route('categories.destroy', $category->id) }}" class="form" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">Deletar</button>
            </form>
            
        </div>
    </div>
</div>
@stop


