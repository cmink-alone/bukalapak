<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\brand;
use Illuminate\Support\Facades\DB;

class brandController extends Controller
{
    function getAllBrand(){

        // if (! $user = JWTAuth::parseToken()->authenticate()) {
        //     return response()->json(['user_not_found'], 404);
        // } //kalo mau spesifik authenticate 1 function

        //eloquent
        $brandList = brand::get();



        return response()->json($brandList,200);
        //pengganti return $userList;
    }

   function addBrand(Request $request){

        //untuk rollback data jika ada yang error sebagian
        // DB::beginTransaction();
 
        // try{
            

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $name = $request->input('myname');

            $image = $request->file('image');
            $input['imagename'] = $name. time().".".$image->getClientOriginalExtension();
            $destinationPath= public_path('/images');
            $image->move($destinationPath, $input['imagename']);

            return $destinationPath.'/'.$input['imagename'].'Name:'.$name;

            $brand ->logo ="localhost:8000/images/".$input['imagename'];

            //images/filename.extension
            //localhost:8000/images/filename.extension







        //     $brand_name = $request->input('brand_name');
        //     $logo = $request->input('logo');
           

        //     //save ke database(eloquent)

        //     $brand = new brand;
        //     $brand->brand_name = $brand_name;
        //     $brand->logo = $logo;
        //     //$brand->save adalah untuk insert
        //     $brand->save();

        //     $brandList= brand::get();
        //     //temannya beginTransaction(); untuk commit data
        //     DB::commit();
        //     return response()->json($brandList, 200);
        // }
        // catch(\Exception $e){

        //     //temannya beginTransaction(); untuk rollback
        //     DB::rollback();
        //     return response()->json(["message" => $e->getMessage()], 500);
        // }


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
