<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProductFormRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //atributos
    protected $repository;
    
    //construtor 
    function __construct(ProductRepositoryInterface $repository) {
        
        $this->repository = $repository;
    }

    
    public function index()
    {
       $products = $this->repository
                        ->orderBy('price', 'ASC')
                        ->relationships('category')
                        ->paginate();
       
       return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductFormRequest $request)
    {
       $product = $this->repository->store($request->all());
        
        return redirect()
                ->route('products.index')
                ->withSuccess('Cadastro realizado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$product = $this->repository->where('id', $id)->first();
        $product = $this->repository->whereFirst('id',$id);
        
        if (!$product)
            return redirect()->back();
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$product = $this->repository->findById($id))
            return redirect()->back();
        
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductFormRequest $request, $id)
    {
        $product = $this->repository->update($id, $request->all());
        
        return redirect()
                ->route('products.index')
                ->withSuccess('Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);
        
        return redirect()
                ->route('products.index')
                ->withSuccess('Produto deletado com sucesso!');
    }
    
    function search(Request $request) 
    {
        $filters = $request->except('_token');
        
        $products = $this->repository->search($request);
            return view('admin.products.index', compact('products','filters'));
    }
}
