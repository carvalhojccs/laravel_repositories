<?php

namespace App\Repositories\Core\QueryBuilder;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Core\BaseQueryBuilderRepository;

class QueryBuilderCategoryRepository extends BaseQueryBuilderRepository implements CategoryRepositoryInterface
{
    protected $table = 'categories';
    
    public function search(array $data) 
    {
        
    } 
    
    public function store(array $data) 
    {
        $data['url'] = kebab_case($data['title']);
        
        return $this->db->table($this->tb)->insert($data);
    }
    
    public function update($id, array $data) 
    {
        $data['url'] = kebab_case($data['title']);
        
        return $this->db->table($this->tb)->where('id', $id)->update($data);
    }
}
