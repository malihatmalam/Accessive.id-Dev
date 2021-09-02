<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\FacilityType;
use Redirect;
use DataTables;
use Illuminate\Support\Str;
// FILE
use File;

class FacilityTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(['role:admin']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facility = FacilityType::where('is_deleted',false)->orderBy('created_at', 'DESC')->get();
        return view('admin.facility_type', compact('facility'));
    }

    public function indexData() // Datatable Index
    {
        // $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        $facility = FacilityType::where('is_deleted',false)->select([
            'facility_type_id',
            'facility_type_title',
            'facility_type_desc',
            'facility_type_icon',
            'facility_order',
            'created_at',
            'updated_at',
        ]);

        return DataTables::eloquent($facility)
        ->addColumn('icon',function ($p){
            if($p->facility_type_icon){
                return '<div class="text-center">
                <img src="/facility_types/'.$p->facility_type_icon.'" width="50px" height="50px" alt="'.$p->facility_type_icon.'" style=" fill: red; vertical-align: middle;">
                </div>';
            }
            else{
                return '<div class="text-center">
                <img src="/pic/user.svg" width="50px" height="50px" alt="no picture">
                </div>';
            }
        })
        ->addColumn('action',function ($p){
            return '<td class:"text-center">
            <a class="btnEditFacility btn-icon" data-toggle="modal" id="editButton" data-target="#editFacilityModal" 
                value="'.$p->facility_type_id.'" class="btn btn-warning inline" >
                <i class="material-icons" style="color: #9c27b0;font-size:1.1rem;cursor: pointer;">edit</i>
                </a>
            <a class="btn-icon remove" id="'.$p->facility_type_id.'" >
            <i class="material-icons" style="color:#f44336;font-size:1.1rem;cursor: pointer;">close</i>
            </a>
            </td>';
        })
        ->rawColumns([
            'icon',
            'action'
        ])->toJson();
    }

    public function detailFacilityType(Request $request)
    {
        $facility = FacilityType::where('facility_type_id', $request->id)->get();
        return response()->json($facility);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'facility_type_title' => ['required', 'string', 'min:2', 'unique:facility_types'],
            'facility_type_desc' => ['required', 'string', 'min:2'],
            // 'facility_order' => ['required', 'min:2'],
            'facility_type_icon' => ['required', 'image', 'mimes:svg'],
        ],
        [
            'facility_type_title.required' => 'Nama tipe fasilitas harus diisi.',
            'facility_type_title.string' => 'Nama tipe fasilitas harus berupa huruf.',
            'facility_type_title.min' => 'Nama tipe fasilitas tidak boleh kurang dari 2 karakter.',
            'facility_type_title.unique' => 'Nama tipe fasilitas sudah dipakai.',
            'facility_type_desc.required' => 'Deskripsi harus diisi.',
            'facility_type_desc.string' => 'Deskripsi harus berupa huruf.',
            'facility_type_desc.min' => 'Deskripsi tidak boleh kurang dari 2 karakter.',
            'facility_type_icon.required' => 'Gambar tipe fasilitas harus dimasukan.',
            'facility_type_icon.image' => 'Gambar tipe fasilitas harus berupa gambar.',
            'facility_type_icon.mimes' => 'Format gambar tipe fasilitas hanya berupa SVG.',

        ]);

        if ($request->hasFile('facility_type_icon')) {
            $file = $request->file('facility_type_icon');
            $filename = time() . Str::slug($request->facility_type_title) . '.' . $file->getClientOriginalExtension();
            $file->move('facility_types', $filename);
            // File::delete('categories/' . $category->category_icon);
            
            $iconFileName = $filename;

            $countInFacility = FacilityType::all();
            $count_facility = $countInFacility->count();
    
            $facilityType = FacilityType::create([
                'facility_type_title' => $request->facility_type_title,
                'facility_type_desc' => $request->facility_type_desc,
                'facility_order' => $count_facility + 1,
                'facility_type_icon' => $iconFileName,
            ]);

        }


        return redirect()->route('facility_type.index')->with(['success' => 'Tipe Fasilitas Baru Ditambahkan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->validate($request,[
            'edit_facility_type_title' => ['required', 'string', 'min:2'],
            'edit_facility_type_desc' => ['required', 'string', 'min:2'],
            // 'facility_order' => ['required', 'min:2'],
            'edit_facility_type_icon' => ['nullable', 'image', 'mimes:svg'],
        ],
        [
            'edit_facility_type_title.required' => 'Nama tipe fasilitas harus diisi.',
            'edit_facility_type_title.string' => 'Nama tipe fasilitas harus berupa huruf.',
            'edit_facility_type_title.min' => 'Nama tipe fasilitas tidak boleh kurang dari 2 karakter.',
            // 'facility_type_title.unique' => 'Nama tipe fasilitas sudah dipakai.',
            'edit_facility_type_desc.required' => 'Deskripsi harus diisi.',
            'edit_facility_type_desc.string' => 'Deskripsi harus berupa huruf.',
            'edit_facility_type_desc.min' => 'Deskripsi tidak boleh kurang dari 2 karakter.',
            // 'facility_type_icon.required' => 'Gambar tipe fasilitas harus dimasukan.',
            'edit_facility_type_icon.image' => 'Gambar tipe fasilitas harus berupa gambar.',
            'edit_facility_type_icon.mimes' => 'Format gambar tipe fasilitas hanya berupa SVG.',

        ]);
        
        $facility = FacilityType::find($id);
        $filename = $facility->facility_type_icon;
        
        if ($request->hasFile('edit_facility_type_icon')) {
            $file = $request->file('edit_facility_type_icon');
            $filename = time() . Str::slug($request->edit_facility_type_title) . '.' . $file->getClientOriginalExtension();
            $file->move('facility_types', $filename);
            File::delete('facility_types/' . $facility->facility_type_icon);
        }

        $iconFileName = $filename;

        $facility->update([
            'facility_type_title' => $request->edit_facility_type_title,
            'facility_type_desc' => $request->edit_facility_type_desc,
            'facility_type_icon' => $iconFileName,
        ]);

        return redirect()->route('facility_type.index')->with(['success' => 'Tipe Fasilitas Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facility = FacilityType::withCount(['Facility'])->find($id);

        if ($facility->Facility_count == 0){
            $facility->is_deleted = true;
            $facility->save();
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}
