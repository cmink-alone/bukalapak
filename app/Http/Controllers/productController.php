<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\product;

class productController extends Controller
{
      function getAllProduct(){

        // if (! $user = JWTAuth::parseToken()->authenticate()) {
        //     return response()->json(['user_not_found'], 404);
        // } //kalo mau spesifik authenticate 1 function

        //eloquent
        $productList = product::get();



        return response()->json($productList,200);
        //pengganti return $userList;
    }

   function addProduct(Request $request){

        //untuk rollback data jika ada yang error sebagian
        DB::beginTransaction();
 
        try{
            

            // $this->validate($request, [
            //     'name' => 'required',
            //     'email'=> 'required|email'
            // ]);

            $product_name = $request->input('product_name');
            $price = $request->input('price');
            $stock = $request->input('stock');
            $description = $request->input('description');
            $condition = $request->input('condition');
            $tags = $request->input('tags');
            $berat = $request->input('berat');
            $category_id = $request->input('category_id');
            $vendor_id = $request->input('vendor_id');
            $brand_id = $request->input('brand_id');
           

            //save ke database(eloquent)

            $product = new brand;
            $product->product_name = $product_name;
            $product->price = $price;
            $product->stock = $stock;
            $product->description = $description;
            $product->condition = $condition;
            $product->tags = $tags;
            $product->berat = $berat;
            $product->category_id = $category_id;
            $product->vendor_id = $vendor_id;
            $product->brand_id  = $brand_id;

            //$brand->save adalah untuk insert
            $product->save();

            $productList= brand::get();
            //temannya beginTransaction(); untuk commit data
            DB::commit();
            return response()->json($productList, 200);
        }
        catch(\Exception $e){

            //temannya beginTransaction(); untuk rollback
            DB::rollback();
            return response()->json(["message" => $e->getMessage()], 500);
        }


    }

    function removeBrand(Request $request){

            // *******


            $id = (integer)$request->input('id'); //integer -> untuk casting $idToRemove
        
           
            // punya kak hasbi
            $brand = brand::find($id); //mirip seperti where
            if(empty($brand)){
                return response()->json(["message"=>"Brand not found"], 404);
            }
            $brand->delete();
            $brandList= brand::get();
            DB::commit();
            return response()->json($brandList, 200);
    }

    
}
