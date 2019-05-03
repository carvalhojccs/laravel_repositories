<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryFormRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $repository;
            
    function __construct(CategoryRepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->repository->orderBy('id')->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateCategoryFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCategoryFormRequest $request)
    {
        $this->repository->store([
           'title'          => $request->title, 
       //    'url'            => $request->url, 
           'description'    => $request->description, 
        ]);
        
        return redirect()
                ->route('categories.index')
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
        $category = $this->repository->findById($id);
        
        if (!$category)
            return redirect()->back();
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$category = $this->repository->findById($id))
            return redirect()->back();
        
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateCategoryFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCategoryFormRequest $request, $id)
    {
        $this->repository
                ->update($id, [
                    'title'          => $request->title, 
         //           'url'            => $request->url, 
                    'description'    => $request->description, 
                ]);
        
        return redirect()->route('categories.index');
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
        return redirect()->route('categories.index');
    }
    
    function search(Request $request) {
               
        /*
         * Filtro simples
         * 
         * $search = $request->search;
         * 
         * $categories = DB::table('categories')
         *       ->where('title', $search)
         *       ->orWhere('url',$search)
         *       ->orwhere('description','LIKE', "%{$search}%")
         *       ->get();
         */        
        
        //Filtro avançado
        $data = $request->except('_token');
        
        $categories = $this->repository->search($data);
        
        return view('admin.categories.index', compact('categories','data'));
    }
}
