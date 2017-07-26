<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
     function getAllCategory(){

        // if (! $user = JWTAuth::parseToken()->authenticate()) {
        //     return response()->json(['user_not_found'], 404);
        // } //kalo mau spesifik authenticate 1 function

        //eloquent
        $categoryList = category::get()->toTree();



        return response()->json($categoryList,200);
        //pengganti return $userList;
    }

   function addCategory(Request $request){

        //untuk rollback data jika ada yang error sebagian
        DB::beginTransaction();
 
        try{
            

            // $this->validate($request, [
            //     'name' => 'required',
            //     'email'=> 'required|email'
            // ]);

            $category_name = $request->input('category_name');
            $parent_id = $request->input('parent_id');
           

            //save ke database(eloquent)

            $category = new category;
            $category->category_name = $category_name;
            $category->parent_id = $parent_id;
            //$brand->save adalah untuk insert
            $category->save();

            $categoryList= category::get()->toTree();
            //temannya beginTransaction(); untuk commit data
            DB::commit();
            return response()->json($categoryList, 200);
        }
        catch(\Exception $e){

            //temannya beginTransaction(); untuk rollback
            DB::rollback();
            return response()->json(["message" => $e->getMessage()], 500);
        }


    }

    function removeCategory(Request $request){

            // ******
            $id = $request->input('id'); //integer -> untuk casting $idToRemove
        
            // punya kak hasbi
            $category = category::find($id); //mirip seperti where
            if(empty($category)){
                return response()->json(["message"=>"Category not found"], 404);
            }
            $category->delete();
            $categoryList= category::get();
            DB::commit();
            return response()->json($categoryList, 200);
    }
}
