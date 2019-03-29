<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Requests\StoreUpdateCategoryFormRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')
                ->orderBy('id','desc')
                ->paginate();
       //dd($categories);
        
        return view('admin.categories.index', compact('categories'));
        
        
        //return $_SERVER['REMOTE_ADDR'];
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
        DB::table('categories')->insert([
           'title'          => $request->title, 
           'url'            => $request->url, 
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
        $category = DB::table('categories')
                ->where('id',$id)
                ->first();
        
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
        $category = DB::table('categories')->where('id', $id)->first();
        
        if (!$category)
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
        DB::table('categories')
                ->where('id',$id)
                ->update([
                    'title'          => $request->title, 
                    'url'            => $request->url, 
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
        DB::table('categories')->where('id', $id)->delete();
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
        
        $categories = DB::table('categories')
                ->where(function ($query) use ($data){
                    if(isset($data['title'])) {
                        $query->where('title',$data['title']);
                    }
                    if(isset($data['url'])) {
                        $query->orWhere('url',$data['url']);
                    }
                    if(isset($data['description'])) {
                        $desc = $data['description'];
                        $query->orWhere('description','LIKE',"%{$desc}%");
                    }
                })
                ->orderBy('id','desc')
                ->paginate();
        
        return view('admin.categories.index', compact('categories','data'));
    }
}
