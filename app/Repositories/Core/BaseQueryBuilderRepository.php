<?php

namespace App\Repositories\Core;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\PropertyTableNotExists;
//use DB;
use Illuminate\Database\DatabaseManager as DB;

class BaseQueryBuilderRepository implements RepositoryInterface
{
 
    protected $tb, $db;
    protected $orderBy = [
        'column' => 'id',
        'order'  => 'DESC',
    ];
            
    function __construct(DB $db) {
        $this->tb = $this->getTable();
        $this->db = $db;
    }

    public function destroy($id) 
    {
        return $this->db->table($this->tb)->where('id', $id)->delete();
    }

    public function findById($id) 
    {
        return $this->db->table($this->tb)->find($id);
    }

    public function get() 
    {
        return $this->db
                ->table($this->tb)
                ->orderBy($this->orderBy['column'],$this->orderBy['order'])
                ->get();
    }

    public function paginate($totalPage = 10) 
    {
        return $this->db
                    ->table($this->tb)
                    ->orderBy($this->orderBy['column'],$this->orderBy['order'])
                    ->paginate($totalPage);
    }

    public function store(array $data) 
    {
        return $this->db->table($this->tb)->insert($data);
    }

    public function update($id, array $data) 
    {
        return $this->db->table($this->tb)->where('id', $id)->update($data);
    }

    public function where($column, $value) 
    {
        return $this->db->table($this->tb)->where($column, $value)->get();
    }

    public function whereFirst($column, $value) 
    {
        return $this->db->table($this->tb)->where($column, $value)->first();
    }
    
    public function orderBy($column, $order = 'DESC') {
        $this->orderBy = [
            'column'    => $column,
            'order'     => $order,
        ];
        
        return $this;
    }

        public function getTable()
    {
        if (!property_exists($this, 'table')) {
            throw new PropertyTableNotExists;
        }
        
        return $this->table;
    }

}
