<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Catagory;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Subcatagory;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get_products(){
        $products = Product::join('brands','products.brand','brands.id')
        ->join('catagorys','products.catagory','catagorys.id')
        ->join('subcatagorys','products.sub_catagory','subcatagorys.id')
        ->select('products.*','brands.name as brand_name', 'catagorys.name as catagory_name', 'subcatagorys.name as subcatagory_name')
        ->get();
        return view('get_products', compact('products'));
    }

    public function get_product($id){
        $product = Product::join('brands','products.brand','brands.id')
        ->join('catagorys','products.catagory','catagorys.id')
        ->join('subcatagorys','products.sub_catagory','subcatagorys.id')
        ->select('products.*','brands.name as brand_name', 'catagorys.name as catagory_name', 'subcatagorys.name as subcatagory_name')
        ->first($id);

        $variants = ProductVariant::where('variants.product_id',$id)
        ->join('colors','variants.color','colors.id')
        ->join('sizes','variants.size','sizes.id')
        ->select('sizes.name as size_name', 'colors.name as color_name', 'variants.*')
        ->get();
        // dd($product);
        return view('get_product', compact('product', 'variants'));
    }

    public function add_product(){
        $colors = Color::all();
        $brands = Brand::all();
        $catagories = Catagory::all();
        $sizes = Size::all();
        return view('add_products', compact('colors','brands','catagories', 'sizes'));
    }

    public function store_product(Request $request){
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'brand'=>'required',
            'catagory'=>'required',
            'sub_catagory'=>'required',
            'color'=>'required',
            'size'=>'required',
            'quantity'=>'required',
            'price'=>'required',
            'selling_price'=>'required',
            'discount_amount'=>'required',
        ]);

        $count_array = [
            count($request->color??[]),
            count($request->size??[]),
            count($request->quantity??[]),
            count($request->price??[]),
            count($request->selling_price??[]),
            count($request->discount_amount??[])
        ];

        $min_count = min($count_array);
        $max_count = max($count_array);
// dd($min_count,$max_count);
        if(($min_count != $max_count) || $min_count == 0){
            $request->validate([
                'field_count_must_be_same' => 'required'
            ],
            [
                'field_count_must_be_same.required' => 'Added more variant rows fields are required.'
            ]);
        }

        try{
            $product = new Product();
            $product->name = $request->name;
            $product->brand = $request->brand;
            $product->catagory = $request->catagory;
            $product->sub_catagory = $request->sub_catagory;
            $product->save();

            
            for($i=0;$i<$max_count;$i++){
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->color = $request->color[$i];
                $variant->size = $request->size[$i];
                $variant->quantity = $request->quantity[$i];
                $variant->price = $request->price[$i];
                $variant->selling_price = $request->selling_price[$i];
                $variant->discount_amount = $request->discount_amount[$i];
                $variant->save();
                unset($variant);
            }


            return redirect()->route('get_products')->with('success','Product successfully saved.');
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function edit_product($id){
        $product = Product::join('brands','products.brand','brands.id')
        ->join('catagorys','products.catagory','catagorys.id')
        ->join('subcatagorys','products.sub_catagory','subcatagorys.id')
        ->select('products.*','brands.name as brand_name', 'catagorys.name as catagory_name', 'subcatagorys.name as subcatagory_name')
        ->first($id);

        $variants = ProductVariant::where('variants.product_id',$id)
        ->join('colors','variants.color','colors.id')
        ->join('sizes','variants.size','sizes.id')
        ->select('sizes.name as size_name', 'colors.name as color_name', 'variants.*')
        ->get();

        $colors = Color::all();
        $brands = Brand::all();
        $catagories = Catagory::all();
        $sizes = Size::all();

        $sub_catagories = Subcatagory::where('catagory',$product->catagory)->get();
        return view('edit_product', compact('product', 'variants', 'sizes', 'catagories', 'brands', 'colors', 'sub_catagories'));
    }

    public function update_product(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'brand'=>'required',
            'catagory'=>'required',
            'sub_catagory'=>'required',
            'color'=>'required',
            'size'=>'required',
            'quantity'=>'required',
            'price'=>'required',
            'selling_price'=>'required',
            'discount_amount'=>'required',
        ]);

        $count_array = [
            count($request->color??[]),
            count($request->size??[]),
            count($request->quantity??[]),
            count($request->price??[]),
            count($request->selling_price??[]),
            count($request->discount_amount??[])
        ];

        $min_count = min($count_array);
        $max_count = max($count_array);
// dd($min_count,$max_count);
        if(($min_count != $max_count) || $min_count == 0){
            $request->validate([
                'field_count_must_be_same' => 'required'
            ],
            [
                'field_count_must_be_same.required' => 'Added more variant rows fields are required.'
            ]);
        }

        try{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->brand = $request->brand;
            $product->catagory = $request->catagory;
            $product->sub_catagory = $request->sub_catagory;
            $product->update();

            $variants = ProductVariant::where('variants.product_id',$id)->delete();
            for($i=0;$i<$max_count;$i++){
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->color = $request->color[$i];
                $variant->size = $request->size[$i];
                $variant->quantity = $request->quantity[$i];
                $variant->price = $request->price[$i];
                $variant->selling_price = $request->selling_price[$i];
                $variant->discount_amount = $request->discount_amount[$i];
                $variant->save();
                unset($variant);
            }


            return redirect()->route('get_products')->with('success','Product successfully updated.');
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function delete_product($id){
        $product = Product::find($id);
        if($product){
            $variants = ProductVariant::where('variants.product_id',$id);
            if($variants->exists()){
                $variants = $variants->delete();
                $variants = ProductVariant::where('variants.product_id',$id);
                if($variants->exists()){
                    return back()->with('error','somthing went wrong, product not deleted.');
                }else{
                    $product = $product->delete();
                    $product = Product::find($id);
                    if($product){
                        return back()->with('error','somthing went wrong, product not deleted but variants are deleted.');
                    }
                    else{
                        return back()->with('success','product successfully delted');
                    }
                }
            }
        }
        return back()->with('error','product not found.');
        
    }


    public function get_sub_catagory($catagory_id){
        $sub_catagories = Subcatagory::where('catagory',$catagory_id)->get();
        return response()->json($sub_catagories);
    }
}
