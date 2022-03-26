<?php



namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait GeneralTraits
{



    public function imageSaver($image)
    {

  
        $imageName = date("Y-m-d-h-i-s-ms") . "." . "png";


        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $path = Storage::disk('local')->put("images/$imageName", base64_decode($image));

        return url("/api/storage/$imageName");
    }


    public function responseForm($message,  $success, $data)
    {
        return response()->json(
            [
                "message" => $message,
                "data" => $data,
                "success" => $success
            ]
        );
    }
}
