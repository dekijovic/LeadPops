<?php


namespace App\Http\Controllers;


use App\Http\Resources\UrlResource;
use App\Repositories\LinksRepository;
use Illuminate\Http\Request;

class UrlController extends Controller
{

    public function url(Request $request, LinksRepository $repo)
    {
        $rec = $repo->find($request->path());

        if($rec){
            return new UrlResource($rec);
        }
        return response(['message' => 'not found']);
    }

}
