<?php

namespace App\Repositories\Core;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\NotEntityDefined;

class BaseEloquentRepository implements RepositoryInterface
{
    protected $entity;
    
    function __construct()
    {
        $this->entity = $this->getEntity();
    }

    
    public function destroy($id) 
    {
        return $this->entity->find($id)->delete();
    }

    public function findById($id)
    {
        return $this->entity->find($id);
    }

    public function get()
    {
        return $this->entity->get();
    }

    public function paginate($totalPage = 10) 
    {
        return $this->entity->paginate($totalPage);
    }

    public function store(array $data) 
    {
        return $this->entity->create($data);
    }

    public function update($id, array $data)
    {
        $entity = $this->findById($id);
        
        return $entity->update($data);
    }

    public function where($column, $value) 
    {
        return $this->entity->where($column, $value)->get();
    }

    public function whereFirst($column, $value) 
    {
        return $this->entity->where($column, $value)->first();
    }
    
    
    //...$relationships é a mesma coisa que array $relationships
    public function relationships(...$relationships)
    {
        $this->entity = $this->entity->with($relationships);
        
        return $this;
    }
    
    public function orderBy($column, $order = 'DESC') {
        $this->entity = $this->entity->orderBy($column, $order);
        
        return $this;
    }

    public function getEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new NotEntityDefined;
        }
        
        return app($this->entity());
    }

}
