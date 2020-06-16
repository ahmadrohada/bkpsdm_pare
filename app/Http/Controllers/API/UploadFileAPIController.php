<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Sasaran;
use App\Models\Program;
use App\Models\Kegiatan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;
use Carbon\Carbon;
use File;

class UploadFileAPIController extends Controller {


    public function FileUpload(Request $request){



        $destinationPath = 'files_upload';
        File::delete($destinationPath.'/tue-jun-16-2020-134-pm96169.jpg');

        if($request->hasFile('file')) {
   
          // Upload path
          $destinationPath = 'files_upload/';
   
          // Create directory if not exists
          if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0755, true);
          }
   
          // Get file extension
          $extension = $request->file('file')->getClientOriginalExtension();
   
          // Valid extensions
          $validextensions = array("jpeg","jpg","png","pdf");
   
          // Check extension
          if(in_array(strtolower($extension), $validextensions)){
   
            // Rename file 
            $fileName = str_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;
   
            // Uploading file to given path
            $upload = $request->file('file')->move($destinationPath, $fileName); 
   
          }

            if ($upload) {
                return response()->json($fileName, 200);
            }
            // Else, return error 400
            else {
                return response()->json('error', 400);
            }

   
        }
     }


}
