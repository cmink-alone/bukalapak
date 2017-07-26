<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\vendor;

class vendorController extends Controller
{
    function getAllVendor(){

        // if (! $user = JWTAuth::parseToken()->authenticate()) {
        //     return response()->json(['user_not_found'], 404);
        // } //kalo mau spesifik authenticate 1 function

        //eloquent
        $vendorList = vendor::get();



        return response()->json($vendorList,200);
        //pengganti return $userList;
    }

   function addVendor(Request $request){

        //untuk rollback data jika ada yang error sebagian
        DB::beginTransaction();
 
        try{
            

            // $this->validate($request, [
            //     'name' => 'required',
            //     'email'=> 'required|email'
            // ]);

            $vendor_name = $request->input('vendor_name');
            $description = $request->input('description');
            $tanggal_bergabung = $request->input('tanggal_bergabung');
            $location = $request->input('location');
            $catatan_pelapak = $request->input('catatan_pelapak');
            $banner_photo = $request->input('banner_photo');
            $thumbnail = $request->input('thumbnail');
            $user_id = $request->input('user_id');
            
           

            //save ke database(eloquent)

            $vendor = new vendor;
            $vendor->vendor_name = $vendor_name;
            $vendor->description = $description;
            $vendor->tanggal_bergabung = $tanggal_bergabung;
            $vendor->location = $location;
            $vendor->catatan_pelapak = $catatan_pelapak;
            $vendor->banner_photo = $banner_photo;
            $vendor->thumbnail = $thumbnail;
            $vendor->user_id = $user_id;
            //$brand->save adalah untuk insert
            $vendor->save();

            $vendorList= vendor::get();
            //temannya beginTransaction(); untuk commit data
            DB::commit();
            return response()->json($vendorList, 200);
        }
        catch(\Exception $e){

            //temannya beginTransaction(); untuk rollback
            DB::rollback();
            return response()->json(["message" => $e->getMessage()], 500);
        }


    }

    function removeVendor(Request $request){

            // *******


            $id = (integer)$request->input('id'); //integer -> untuk casting $idToRemove
        
           
            // punya kak hasbi
            $vendor = vendor::find($id); //mirip seperti where
            if(empty($vendor)){
                return response()->json(["message"=>"Vendor not found"], 404);
            }
            $vendor->delete();
            $vendorList= vendor::get();
            DB::commit();
            return response()->json($vendorList, 200);
    }
}
