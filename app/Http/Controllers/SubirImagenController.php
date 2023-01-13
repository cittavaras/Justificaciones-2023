<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\SubirImagen;
use Log;
use Carbon\Carbon;

class SubirImagenController extends Controller
{
    public function fileStore(Request $request)
    {
        Log::Debug($request->file('file')->getClientOriginalName() + '######################################################REQUEST');
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);

        $imageUpload = new SubirImagen();
        $imageUpload->nfolio = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }

    public function upload(Request $request)
    {
        $input = Input::all();
        Log::Debug($input);
        Log::Debug(request()->route()->parameter('userId'));
        Log::Debug("NUMERO DE FOLIO: ".$request->folio);
        Log::Debug("SUBIR ARCHIVOS##############################################################");
        $time = Carbon::now();
        $image = $request->file('file');
	//linea agregada 10052019
        Log::Debug("NOMBRE".$request->file('file'));
        $extension = $image->getClientOriginalExtension();
        $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
        // Creating the file name: random string followed by the day, random number and the hour
        // $filename = str_random(8).date_format($time,'d').rand(1,9).date_format($time,'h').".".$extension;
        $nombreSinExtension = date_format($time,'Y').date_format($time,'m').str_random(8);
        $filename = $request->folio.".". $nombreSinExtension.".".$extension;
        // This is our upload main function, storing the image in the storage that named 'public'
        $upload_success = $image->storeAs($directory, $filename, 'public');
        // If the upload is successful, return the name of directory/filename of the upload.
        if ($upload_success) {
            $imageUpload = new SubirImagen();
            $imageUpload->nfolio = $request->folio;
            $imageUpload->url = $directory.'/'.$filename;
            Log::Debug("URL: ".$imageUpload->url);
            $imageUpload->save();
            return response()->json($upload_success, 200);
        }
        // Else, return error 400
        else {
            return response()->json('error', 400);
        }
    }

}
