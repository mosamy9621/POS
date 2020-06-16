<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    //
    public  function  index(Request $request){


       $categories=Category::on();
        if($request->search){
            $categories=Category::where('name','like','%'.$request->search .'%');
        }
        $categories=$categories->latest()->paginate(5);

        return view('Dashboard.categories.index',compact('categories'));
    }

    public function create(){
        $this->authorize('CreateCategories',Category::getInstance());
        return view('Dashboard.categories.create');
    }
    public function store(Request $request){

        $requested=$request->validate(['name'=>['required','string','unique:categories']]);
        Category::create($requested);
        session()->flash('success',__('site.added_successfully'));
        return redirect(route('dashboard.categories.index'));

    }

    public function edit(Category $category){
        $this->authorize('EditCategories',Category::getInstance());
        return view('Dashboard.categories.edit',compact('category'));
    }

    public function update(Request $request, Category $category){
        $requested=$request->validate(['name'=>['required','string',Rule::unique('categories')->ignore($category)]]);
        $category->update($requested);
        session()->flash('success',__('site.edited_successfully'));
        return redirect(route('dashboard.categories.index'));


    }

    public function destroy(Category $category){
        $category->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect(route('dashboard.categories.index'));


    }
}

