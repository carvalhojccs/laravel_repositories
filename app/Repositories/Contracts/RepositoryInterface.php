<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface 
{
    //busca todos os itens
    public function get();
    
    //busca um item pelo seu id
    public function findById($id);
    
    //busca um item através da coluna e valor
    public function where($column, $value);
    
    //busca o primeiro item atraves da coluna e valor
    public function whereFirst($column, $value);
    
    //realiza a paginação com o valor default de 10 itens por página
    public function paginate($totalPage = 10);
    
    //persiste um item na tabela
    public function store(array $data);
    
    //atualiza um item na tabela
    public function update($id, array $data);
    
    //deleta um item da tabela
    public function destroy($id);
    
    //ordena uma coluna
    public function orderBy($column, $order = 'DESC');
    
}