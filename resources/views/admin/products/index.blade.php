@extends('adminlte::page')

@section('title','Listagem de Produtos')

@section('content_header')
<h1>
    <a href="{{ route('products.create') }}" class="btn btn-success">Adicionar</a>
    Gestão de Produtos</h1>

<ol class="breadcrumb">
    <li><a href="{{ route('admin') }}">Dashboard</a></li>
    <li><a href="{{ route('products.index') }}">Produtos</a></li>
</ol>

@stop

@section('content')
<div class="content row">
    <div class="box box-primary">
        <div class="body">
            {{ Form::open(['route' => 'products.search', 'class' => 'form form-inline']) }}
                {{ Form::select('category',$categories, null,['placeholder' => 'Categoria...','class' => 'form-control']) }}
                {{ Form::text('name',null,['placeholder' => 'Nome:', 'class' => 'form form-control']) }}
                {{ Form::text('price',null,['placeholder' => 'Preço:', 'class' => 'form form-control']) }}
                {{ Form::submit('Pesquisar',['class' => 'btn btn-success']) }}
            {{ Form::close() }}
        </div>
    </div>
    
    <div class="box">
        
        <div class="box-body">
            
            @include('admin.includes.alerts')
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Preço</th>
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <th scope="row">{{ $product->name }}</th>
                        <td>{{ $product->category->title }}</td>
                        <td>R$ {{ $product->price }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="badge bg-yellow">Editar</a>
                            <a href="{{ route('products.show', $product->id) }}" class="badge bg-info">Detalhes</a>
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
            @if(isset($filters))
                {!! $products->appends($filters)->links() !!}
            @else
                {!! $products->links() !!}
            @endif
            
            
        </div>
    </div>
</div>
@stop


