<?php

namespace App\Http\Controllers;

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
    // Contructor for middleware
    public function __construct()
    {
        $this->middleware(['role:admin']);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $place = Place::where('is_deleted',false)->orderBy('title_name', 'ASC')->get();
        // dd('place');
        return view('admin.place', compact('place'));
    }

    public function indexData() // Datatable Index
    {
        // $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        $place = Place::with(['Category'])->where('is_deleted',false)->where('is_verfied',true)->select([
            'place_id',
            'title_name',
            'category_id',
            'latitude',
            'longitude',
            'phone',
            'address',
            'website',
            'created_at',
            'updated_at',
        ]);

        return DataTables::eloquent($place)
        ->addColumn('action',function ($p){
            return '<td class:"text-center">
            <a class="btn-icon" href="/place/'.$p->place_id.'"  value="'.$p->facility_type_id.'" 
                class="btn btn-warning inline" >
                <i class="material-icons" style="color: #9c27b0;font-size:1.1rem;cursor: pointer;">visibility</i>
                </a>
            <a class="btn-icon remove" id="'.$p->place_id.'" >
            <i class="material-icons" style="color:#f44336;font-size:1.1rem;cursor: pointer;">close</i>
            </a>
            </td>';
        })
        ->rawColumns([
            // 'icon',
            'action'
        ])->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facility_type = FacilityType::where('is_deleted',false)->orderBy('facility_order')->get();
        $category = Category::where('is_deleted',false)->orderBy('category_title')->get();

        return view('admin.place_create', compact('facility_type','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title_name' => ['required', 'string', 'max:255'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'phone' => ['required', 'min:10', 'max:15'],
            'address' => ['required', 'string'],
            'address_gmap' => ['required'],
            'category_id'=> ['required'],
            'place_photo' => ['nullable'],
            'place_photo.*' => ['image', 'mimes:jpeg,png,jpg' , 'max:4096'],
        ],
        [
            'title_name.required' => 'Nama tempat tidak boleh kosong',
            'title_name.string' => 'Nama tempat harus berupa huruf',
            'title_name.max' => 'Nama tempat tidak boleh lebih dari 255 karakter',

            'latitude.required' => 'Silahkan pilih tempat di maps',
            'longitude.required' => 'Silahkan pilih tempat di maps',

            // 'phone.min' => 'No telp tidak boleh kurang dari 10 angka',
            // 'phone.max' => 'No telp tidak boleh lebih dari 15 angka',
            'phone.required' => 'No telp tidak boleh kosong',
            'phone.min' => 'No telp tidak boleh kurang dari 10 angka',
            'phone.max' => 'No telp tidak boleh lebih dari 15 angka',
            
            'address.required' => 'Alamat tidak boleh kosong',
            'address.string' => 'Alamat harus berupa huruf',

            'category_id.required' => 'Kategori tidak boleh kosong',
            
            'place_photo.*.image' => 'Foto tempat harus berupa gambar.',
            'place_photo.*.mimes' => 'Format foto tempat hanya berupa PNG, JPG dan JPEG',
            'place_photo.*.max' => 'Ukuran file maksimal 4 mb'

        ]);


        // $facility_type = FacilityType::orderBy('facility_order')->get();

        
        $place = Place::create([
            'title_name' => $request->title_name,
            'category_id' => $request->category_id,
            'phone' => $request->phone,
            'website' => $request->website,
            'address' => $request->address,
            'address_gmap' => $request->address_gmap,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_verfied' => true,
        ]);


        if ($request->hasFile('place_photo')) {
            $image = $request->file('place_photo');
            $number = 0;
            foreach ($image as $files) {
                
                $file_name = time() . "-" . $number . ".". $files->getClientOriginalExtension();
                $files->move('place_photos', $file_name);

                $place_photo = PlacePhoto::create([
                    'place_id' => $place->place_id,
                    'place_photo_url' => $file_name,
                ]);

                $number++;
            }
        }
        
        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Tempat Berhasil Ditambahkan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        }])->find($id);

        $place2 = Place::find($id);

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

        return view('admin.place_detail', compact('place','place2', 'guide'));
    //     return response()->json([
    //         'status' => 'Success',
    //         'data' => $place
    //    ]);
    }

    public function test_show($id)
    {
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
        }])->find($id);

        $guide = Guide::where('place_id', $place->place_id)->with([
            'GuidePhoto'=> function($query)
            {
                $query->where('guide_photos.is_deleted', false);
            },
            'GuideType'=> function($query)
            {
                $query->where('guide_types.is_deleted', false);
            }
            ])->get();

        // return view('admin.place_detail', compact('place','place2'));
        return response()->json([
            'status' => 'Success',
            'data-place' => $place,
            'data-guide' => $guide
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function photo_add(Request $request, $id)
    {
        $this->validate($request,[
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg' , 'max:4096'],
        ],
        [     
            'place_photo.image' => 'Foto tempat harus berupa gambar.',
            'place_photo.mimes' => 'Format foto tempat hanya berupa PNG, JPG dan JPEG',
            'place_photo.max' => 'Ukuran file maksimal 4 mb'

        ]);

        $place = Place::find($id);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            
            $file_name = time() . "-" . "add-new" . ".". $image->getClientOriginalExtension();
            $image->move('place_photos', $file_name);

            $place_photo = PlacePhoto::create([
                'place_id' => $place->place_id,
                'place_photo_url' => $file_name,
            ]);
        }

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Foto Berhasil Ditambahkan!']);

    }

    public function photo_deleted(Request $request, $id)
    {

        $place_photo  = PlacePhoto::find($request->place_photo_id);
        $place = Place::find($id);

        $place_photo->is_deleted = true;
        $place_photo->save();

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Foto Berhasil Dihapus!']);

    }

    public function general_edit($id)
    {
        $place = Place::find($id);
        $facility_type = FacilityType::where('is_deleted',false)->orderBy('facility_order')->get();
        $category = Category::where('is_deleted',false)->orderBy('category_title')->get();

        return view('admin.place_edit-general', compact('facility_type','category','place' ));
    }

    public function general_update(Request $request, $id)
    {
        $this->validate($request,[
            'title_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:10', 'max:15'],
            'category_id'=> ['required'],
        ],
        [
            'title_name.required' => 'Nama tempat tidak boleh kosong',
            'title_name.string' => 'Nama tempat harus berupa huruf',
            'title_name.max' => 'Nama tempat tidak boleh lebih dari 255 karakter',

            // 'phone.min' => 'No telp tidak boleh kurang dari 10 angka',
            // 'phone.max' => 'No telp tidak boleh lebih dari 15 angka',
            'phone.required' => 'No telp tidak boleh kosong',
            'phone.min' => 'No telp tidak boleh kurang dari 10 angka',
            'phone.max' => 'No telp tidak boleh lebih dari 15 angka',
            
            'category_id.required' => 'Kategori tidak boleh kosong',

        ]);

        $place = Place::find($id);
        $place->update([
            'title_name' => $request->title_name,
            'phone' => $request->phone,
            'website' => $request->website,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Data Tempat Telah Berhasil Diperbaharui!']);
    }

    public function location_edit($id)
    {
        $place = Place::find($id);
        // $facility_type = FacilityType::where('is_deleted',false)->orderBy('facility_order')->get();

        return view('admin.place_edit-location', compact('place' ));
    }

    public function location_update(Request $request, $id)
    {
        $this->validate($request,[
            'latitude' => ['required'],
            'longitude' => ['required'],
            'address' => ['required', 'string'],
            'address_gmap' => ['required'],
        ],
        [
            'latitude.required' => 'Silahkan pilih tempat di maps',
            'longitude.required' => 'Silahkan pilih tempat di maps',

            'address.required' => 'Alamat tidak boleh kosong',
            'address.string' => 'Alamat harus berupa huruf',
        ]);

        $place = Place::find($id);
        $place->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'address_gmap' => $request->address_gmap,
        ]);

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Data Tempat Telah Berhasil Diperbaharui!']);
    }

    public function facility_edit($id)
    {
        $place = Place::with([
        'FacilityType' => function($query)
        {
            $query->where('facilities.is_deleted', false);
        }])->find($id);

        $facility_type = FacilityType::where('is_deleted',false)->orderBy('facility_order')->get();

        return view('admin.place_edit-facility', compact('place','facility_type' ));
    }

    public function facility_update(Request $request, $id)
    {
        // $this->validate($request,[
        //     'facility' => ['required'],
        // ],
        // [
        //     'latitude.required' => 'Silahkan pilih tempat di maps',
        //     'longitude.required' => 'Silahkan pilih tempat di maps',

        //     'address.required' => 'Alamat tidak boleh kosong',
        //     'address.string' => 'Alamat harus berupa huruf',
        // ]);

        $place = Place::with([
            'Facility' => function($query)
            {
                $query->where('is_deleted', false);
            }])->find($id);

        $facility = $request->facility;
        
        if ($facility == !null) {
            # Check.
            foreach ($facility as $f ) {
                if (!in_array( $f, $place->Facility->pluck('facility_type_id')->all())) {
                    $facility_have = Facility::where('place_id', $place->place_id)->where('facility_type_id', $f)->first();
                    if ($facility_have == null) {
                        # code...
                        $facility_create = Facility::create([
                            'place_id' => $place->place_id,
                            'facility_type_id' => $f,
                        ]);
                    }else {
                        # code...
                        $facility_have->is_deleted = false;
                        $facility_have->save();
                    }
                }else {
                }
            }
            # Uncheck.
            $facility_have_2 = Facility::where('place_id', $place->place_id)->whereNotIn('facility_type_id', $facility)->get();
            if ($facility_have_2 == !null){
                foreach ($facility_have_2 as $f2 ){
                    $f2->is_deleted = true;
                    $f2->save();
                }
            }
        }

        if ($facility == null){
            $facility_have_3 = Facility::where('place_id', $place->place_id)->get();
                if ($facility_have_3 == !null){
                    foreach ($facility_have_3 as $f3 ){
                        $f3->is_deleted = true;
                        $f3->save();
                    }
                }
        }


        // // Uncheck All
        // $facility_have_3 = Facility::where('place_id', $place->place_id)->get();
        // if ($facility_have_3 == !null){
        //     foreach ($facility_have_3 as $fh ){
        //         $fh->is_deleted = true;
        //         $fh->save();
        //     }
        // }

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Data Tempat Telah Berhasil Diperbaharui!']);
    }

    public function guide_create($id)
    {
        $place = Place::find($id);
        $guide_type = GuideType::where('is_deleted',false)->get();
        // $facility_type = FacilityType::where('is_deleted',false)->orderBy('facility_order')->get();

        return view('admin.place_create-guide', compact('place','guide_type' ));
    }

    public function guide_store(Request $request, $id)
    {
        $this->validate($request,[
            'guide_type_id'=> ['required'],
            'guide_desc' => ['required'],
            'guide_photo' => ['nullable'],
            'guide_photo.*' => ['image', 'mimes:jpeg,png,jpg' , 'max:4096'],
        ],
        [
            'guide_desc.required' => 'Deskripsi tidak boleh kosong',
            'guide_type_id.required' => 'Jenis panduan tidak boleh kosong',
            
            'guide_photo.*.image' => 'Foto tempat harus berupa gambar.',
            'guide_photo.*.mimes' => 'Format foto tempat hanya berupa PNG, JPG dan JPEG',
            'guide_photo.*.max' => 'Ukuran file maksimal 4 mb'

        ]);


        // $facility_type = FacilityType::orderBy('facility_order')->get();

        $place = Place::find($id);

        $guide = Guide::create([
            'place_id' => $id,
            'guide_type_id' => $request->guide_type_id, 
            'guide_desc' => $request->guide_desc, 
        ]);


        if ($request->hasFile('guide_photo')) {
            $image = $request->file('guide_photo');
            $number = 0;
            foreach ($image as $files) {
                
                $file_name = time() . "-" . $number . ".". $files->getClientOriginalExtension();
                $files->move('guide_photos', $file_name);

                $guide_photo = GuidePhoto::create([
                    'guide_id' => $guide->guide_id,
                    'guide_photo_url' => $file_name,
                ]);

                $number++;
            }
        }
        
        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Tempat Berhasil Ditambahkan!']);
    }
    
    public function guide_edit($guide_id)
    {
        $guide = Guide::with('Place','GuideType')->find($guide_id);
        $place = Place::find($guide->place_id);
        $guide_type = GuideType::where('is_deleted',false)->get();
        // $facility_type = FacilityType::where('is_deleted',false)->orderBy('facility_order')->get();

        return view('admin.place_edit-guide', compact('guide','guide_type'));
        // return response()->json([
        //             'status' => 'Success',
        //             'guide' => $guide,
        //        ]);
    }
    
    public function guide_update(Request $request, $id)
    {
        $this->validate($request,[
            'guide_type_id'=> ['required'],
            'guide_desc' => ['required'],
            'guide_photo' => ['nullable'],
            'guide_photo.*' => ['image', 'mimes:jpeg,png,jpg' , 'max:4096'],
        ],
        [
            'guide_desc.required' => 'Deskripsi tidak boleh kosong',
            'guide_type_id.required' => 'Jenis panduan tidak boleh kosong',
            
            'guide_photo.*.image' => 'Foto tempat harus berupa gambar.',
            'guide_photo.*.mimes' => 'Format foto tempat hanya berupa PNG, JPG dan JPEG',
            'guide_photo.*.max' => 'Ukuran file maksimal 4 mb'

        ]);


        // $facility_type = FacilityType::orderBy('facility_order')->get();

        $guide = Guide::find($id);
        $guide->update([
            'guide_type_id' => $request->guide_type_id, 
            'guide_desc' => $request->guide_desc, 
        ]);

        $place = Place::find($guide->Place->place_id);

        if ($request->hasFile('guide_photo')) {
            $image = $request->file('guide_photo');
            $number = 0;
            foreach ($image as $files) {
                
                $file_name = time() . "-" . $number . ".". $files->getClientOriginalExtension();
                $files->move('guide_photos', $file_name);

                $guide_photo = GuidePhoto::create([
                    'guide_id' => $guide->guide_id,
                    'guide_photo_url' => $file_name,
                ]);

                $number++;
            }
        }
        
        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Tempat Berhasil Ditambahkan!']);
    }

    public function guide_photo_deleted(Request $request, $id)
    {

        $guide_photo  = GuidePhoto::find($request->guide_photo_id);
        $place = Place::find($id);

        $guide_photo->is_deleted = true;
        $guide_photo->save();

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Foto Panduan Berhasil Dihapus!']);

    }

    public function guide_delete(Request $request, $id)
    {
        $guide = Guide::find($id);
        // $guide_photo  = GuidePhoto::find($request->guide_photo_id);
        $place = Place::find($guide->Place->place_id);

        $guide->is_deleted = true;
        $guide->save();

        return redirect()->route('place.show', $place->place_id)->with(['success' => 'Panduan Tempat Berhasil Dihapus!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id);

        $place->is_deleted = true;
        $place->save();
        return response()->json([
            'status' => 'success'
        ]);
        // if ($facility->Facility_count == 0){
        // }
        // return response()->json([
        //     'status' => 'error'
        // ]);
    }
}
