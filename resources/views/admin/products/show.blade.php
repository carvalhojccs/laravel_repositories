@extends('adminlte::page')

@section('title','Detalhes do Produto')

@section('content_header')
<h1>Produto: {{ $product->name }}</h1>

<ol class="breadcrumb">
    <li><a href="{{ route('admin') }}">Dashboard</a></li>
    <li><a href="{{ route('products.index') }}">Produtos</a></li>
    <li><a href="{{ route('products.show',$product->id) }}" class="active">Dashboard</a></li>

</ol>


@stop

@section('content')
<div class="content row">
    <div class="box box-success">
        <div class="box-body">
            <p><strong>ID:</strong>{{ $product->id }}</p>
            <p><strong>NOME:</strong>{{ $product->name }}</p>
            <p><strong>CATEGORIA:</strong>{{ $product->category->title }}</p>
            <p><strong>PREÇO:</strong>{{ $product->price }}</p>
            
            <hr>
            
            {{ Form::open(['method' => 'DELETE','route' => ['products.destroy', $product->id], 'class' => 'form']) }}
            {{ Form::submit('Deletar',['class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop


