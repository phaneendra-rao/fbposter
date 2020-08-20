<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;
use App\Http\Resources\GroupResource;
use File;
use Response;

class GroupPostImageController extends Controller
{
    /**
     * show post image by file name.
     * @return Response
     */
    public function showImageByFileName(Request $request, $filename)
    {
        $path = storage_path() . '/app/public/post_images/' . $filename;
        if(!File::exists($path)) abort(404);
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
