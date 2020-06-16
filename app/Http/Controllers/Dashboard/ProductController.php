<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    //
    public  function index(Request $request){

        $this->authorize('ReadProducts',Product::getInstance());

        $products=Product::on();
        if($request->search || $request->category){
             if(ctype_digit($request->search)){
                 $products= $products->where('purchased_price','like','%'.$request->search.'%')
                     ->orWhere('selling_price','like','%'.$request->search.'%')
                     ->orWhere('stock','like','%'.$request->search.'%');

             }
             else if(gettype($request->search)=='string'){
                $products= $products->where('name','like','%'.$request->search.'%')
                     ->orWhere('description','like','%'.$request->search.'%');
             }
             if($request->category){
                $products=$products->where('category_id','=',$request->category);
             }
        }

        $products=$products->latest()->paginate(2);
        $categories = Category::all();

        return view('dashboard.products.index',compact('products','categories'));
    }

    public  function create(){

        $this->authorize('CreateProducts',Product::getInstance());

        $categories=Category::all();

        return view('dashboard.products.create',compact('categories'));

    }

    public function store(Request $request){

        $requested_data = $request->validate([
            'name'=>['required','string',Rule::unique('products')],
            'description'=>['required','string'],
            'purchased_price'=>['required','numeric','between:0.1 ,999999.99'],
            'selling_price'=>['required','numeric','between:0.1 ,999999.99'],
            'stock'=>['required','numeric'],
            'image'=>['image'],
            'category'=>['required','numeric']

        ]);
        if($request->image) {
            $requested_data['image'] = Image::make($request->image)->resize(150, null,
                function ($constrain) {
                    $constrain->aspectRatio();
                })
                ->save(public_path('Uploads\products\\' . $request->image->hashName()))->basename;
        }

        $product= new Product();
        $product->fill($requested_data);
        $product->category()->associate($requested_data['category']);
        $product->save();

        session()->flash('success',__('site.added_successfully'));
        return redirect(route('dashboard.products.index'));


    }

    public  function edit(Product $product){
        $this->authorize('EditProducts',Product::getInstance());

        $categories=Category::all();
        return view('dashboard.products.edit',compact(['product','categories']));
    }
    public  function update(Product $product ,Request $request){

        $requested_data = $request->validate([
            'name'=>['required','string',Rule::unique('products')->ignore($product)],
            'description'=>['required','string'],
            'purchased_price'=>['required','numeric','between:0.1 ,999999.99'],
            'selling_price'=>['required','numeric','between:0.1 ,999999.99'],
            'stock'=>['required','numeric'],
            'image'=>['image'],
            'category'=>['required','numeric']

        ]);
        if($request->image) {
            $requested_data['image'] = Image::make($request->image)->resize(150, null,
                function ($constrain) {
                    $constrain->aspectRatio();
                })
                ->save(public_path('Uploads\products\\' . $request->image->hashName()))->basename;
        }

        $product->category()->associate($requested_data['category']);
        $product->update($requested_data);

        session()->flash('success',__('site.edited_successfully'));
        return redirect(route('dashboard.products.index'));
    }

    public function destroy(Product $product){
        $this->authorize('DeleteProducts',Product::getInstance());
        if($product->hasImage()){
            Storage::disk('public_uploads')->delete('/products/'.$product->image);
        }

        $product->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect(route('dashboard.products.index'));
    }


}
