<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ], [
            'name.required' => "Le champ nom de la catégorie est obligatoire",
            'name.min' => "Vous devez entrer au minimum 3 caractères"
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = time() . Str::slug($request->name);

        $category->save();
        if ($category->save()) {
            flashy()->success('Catégorie enrégistrée avec succès');
        } else {
            flashy()->error('Nous avons rencontré une erreur, veuillez réessayer!');
        }
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|min:3'
        ], [
            'name.required' => "Le champ nom de la catégorie est obligatoire",
            'name.min' => "Vous devez entrer au minimum 3 caractères"
        ]);

        $category = Category::where('slug', $slug)->first();
        $category->name = $request->name;

        $category->save();
        if ($category->save()) {
            flashy()->success('Catégorie mise à jour avec succès');
        } else {
            flashy()->error('Nous avons rencontré une erreur, veuillez réessayer!');
        }
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        flashy()->success('Catégorie mise à jour avec succès');
        return redirect()->route('admin.category.index');
    }
}