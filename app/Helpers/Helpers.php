<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// upload image 
function uploadImage($request, $model = '' ){
    $model        = Str::plural($model);
    $model        = Str::ucfirst($model);
    $path         = "/Images/".$model;
     $originalName =  $request->getClientOriginalName(); // Get file Original Name
    $imageName    = str_replace(' ','','pentakill_' . time() . $originalName);  // Set Image name
    $request->storeAs($path, $imageName,'public');
     return $imageName;
}

// delete image
if(!function_exists('deleteImage')){

    function deleteImage($imageName, $model){
        $model = Str::plural($model);
        $model = Str::ucfirst($model);

        if ($imageName != 'default.png'){
            $path = "/Images/" . $model . '/' .$imageName;
            Storage::disk('public')->delete($path);
        }
    }
}
// get image
if(!function_exists('getImagePathFromDirectory')){

    function getImagePathFromDirectory( $imageName , $directory = null , $defaultImage = 'default.svg'  ): string
    {
      
        $imagePath = public_path('/storage/Images'.'/' . $directory . '/' . $imageName);
        
        if ( $imageName && $directory && file_exists( $imagePath ) ) // check if the directory is null or the image doesn't exist
            return asset('/storage/Images') .'/' . $directory . '/' . $imageName;
        else
            return asset('placeholder_images/' . $defaultImage);

    }

}



?>