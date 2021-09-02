<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Category;
use App\Place;
use App\PlacePhoto;
use App\RecommendedPlace;
use App\Guide;
use App\GuideType;
use App\GuidePhoto;
use App\FacilityType;
use App\Facility;
use App\User;
use App\Review;
use Illuminate\Validation\Rule;
use Redirect;
use DataTables;
use Illuminate\Support\Str;
// FILE
use File;

class PlaceController extends Controller
{
    public $successStatus = 200;

    public function detailPlace($place_id)
    {
        # code...
        $user = Auth::guard('api')->user();

        $user_id = $user->user_id;

        $place = Place::with(['Category',
        'PlacePhoto' => function($query)
        {
            $query->where('place_photos.is_deleted', false);
        }
        , 'Guide'=> function($query)
        {
            $query->where('guides.is_deleted', false);
        }
        , 'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }
        ,'CollectionHas' => function($query) use ($user_id)
        {
            $query->where('collections.user_id',$user_id)->where('collections.is_deleted', false);
        }])->find($place_id);


        $guide = Guide::where('place_id', $place->place_id)->where('is_deleted', false)->with([
            'GuidePhoto'=> function($query)
            {
                $query->where('guide_photos.is_deleted', false);
            },
            'GuideType'=> function($query)
            {
                $query->where('guide_types.is_deleted', false);
            }
            ])->get();

        return response()->json([
            'success'=>true,
            'place' => $place, 
            'guide' => $guide
        ], $this->successStatus); 

    }

    public function listFacilityPlace($place_id)
    {
        # code...
        $user = Auth::guard('api')->user();

        $place = Place::with(['Category'])->find($place_id);

        $facility = Facility::with(['FacilityType'])->where('place_id',$place_id)->where('is_deleted',false)->get();

        return response()->json([
            'success'=>true,
            'place' => $place,
            'facility' => $facility 
        ], $this->successStatus); 
    }

    public function listGuidePlace($place_id)
    {
        # code...
        $user = Auth::guard('api')->user();

        $place = Place::with(['Category'])->find($place_id);

        $guide = Guide::where('place_id', $place_id)->where('is_deleted', false)->with([
            'GuidePhoto'=> function($query)
            {
                $query->where('guide_photos.is_deleted', false);
            },
            'GuideType'=> function($query)
            {
                $query->where('guide_types.is_deleted', false);
            }
            ])->get();

        return response()->json([
            'success'=>true,
            'place' => $place,
            'guide' => $guide 
        ], $this->successStatus); 

    }

    public function detailGuidePlace($guide_id)
    {
        # code...
        $user = Auth::guard('api')->user();

        $guide = Guide::where('is_deleted', false)->with([
            'GuidePhoto'=> function($query)
            {
                $query->where('guide_photos.is_deleted', false);
            },
            'GuideType'=> function($query)
            {
                $query->where('guide_types.is_deleted', false);
            }
            ])->find($guide_id);

        
            return response()->json([
            'success'=>true,
            'guide' => $guide 
        ], $this->successStatus); 

    }


    
}
