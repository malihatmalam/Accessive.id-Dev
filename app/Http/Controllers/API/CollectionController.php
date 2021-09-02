<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\User;
use App\Place;
use App\Collection;
use Illuminate\Validation\Rule;
use Redirect;
use DataTables;
use Illuminate\Support\Str;
// FILE
use File;

class CollectionController extends Controller
{
    public $successStatus = 200;

    public function getCollection($user_id)
    {
        # code...
        $user = Auth::guard('api')->user();

        $collection = Collection::with(['Place'])->where('is_deleted', false)->where('user_id',$user_id)->get();

        return response()->json([
            'success'=>true,
            'collections' => $collection
        ], $this->successStatus); 

    }

    public function postCollection(Request $request)
    {
        # code...
        $user = Auth::guard('api')->user();

        $collection = Collection::create([
            'user_id' => $request->user_id,
            'place_id' => $request->user_id,
            'is_deleted' => false
        ]);

        return response()->json([
            'success'=>true,
            'collection' => $collection, 
        ], $this->successStatus); 

    }

    public function deletedCollection(Request $request)
    {
        # code...
        $user = Auth::guard('api')->user();

        $collection = Collection::find($request->collection_id);

        $collection->delete();

        return response()->json([
            'success'=>true,
            'message' => "Koleksi brhasil dihapus", 
        ], $this->successStatus); 

    }

    
}
