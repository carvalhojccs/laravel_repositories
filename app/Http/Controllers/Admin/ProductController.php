<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreUpdateProductFormRequest;

class ProductController extends Controller
{
    //atributos
    protected $product;
    
    //construtor 
    function __construct(Product $product) {
        $this->product = $product;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * public function index(Product $product) é a mesma coisa que
     * public function index(){
     *  $product = new Product
     * }
     * 
     */
    public function index()
    {
       //retorna os produtos e seus relacionamentos com a tabela category
       $products = $this->product->with('category')->paginate(10);
       
       return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*
         * Variável disponibilizada através do view composer em AppServiceProvider@boot
         */
        //recupera todas as categorias
        //$categories = Category::pluck('title','id');
        
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
        //recupera a categoria pelo id
        //$category = Category::find($request->category_id);
        
        //persiste os dados na tabela produtos
        //$product = $category->products()->create($request->all());
        
        //outra alternativa para cadastro
        $product = $this->product->create($request->all());
        
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
        $product = $this->product->with('category')->where('id', $id)->first();
        
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
        /*
         * Variável disponibilizada através do view composer em AppServiceProvider@boot
         */
        //recupera todas as categorias
        //$categories = Category::pluck('title','id');
        
        
        if (!$product = $this->product->find($id))
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
        $product = $this->product->find($id);
        
        $product->update($request->all());
        
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
        $this->product->find($id)->delete();
        
        return redirect()
                ->route('products.index')
                ->withSuccess('Produto deletado com sucesso!');
    }
    
    function search(Request $request) 
    {
        $filters = $request->except('_token');
        
        $products = $this->product
                    ->with('category')
                    ->where(function ($query) use ($request){
                        if ($request->name){
                            $filter = $request->name;
                            $query->where(function ($querySub) use ($filter){
                                $querySub->where('name','LIKE',"%{$filter}%")
                                        ->orWhere('description','LIKE',"%{$filter}%");
                            });
                        }
                        if ($request->price){
                            $query->where('price',$request->price);
                        }
                        
                        if ($request->category){
                            $query->orWhere('category_id',$request->category);
                        }
                    })
                    ->paginate(10);
            return view('admin.products.index', compact('products','filters'));
    }
}
