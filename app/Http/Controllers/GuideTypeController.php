<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\GuideType;
use Redirect;
use DataTables;
use Illuminate\Support\Str;
// FILE
use File;

class GuideTypeController extends Controller
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
        $guide = GuideType::where('is_deleted',false)->orderBy('created_at', 'DESC')->get();
        return view('admin.guide_type', compact('guide'));
    }

    public function indexData() // Datatable Index
    {
        // $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        $guide = GuideType::where('is_deleted',false)->select([
            'guide_type_id',
            'guide_type_title',
            'guide_type_desc',
            'guide_type_icon',
            // 'facility_order',
            'created_at',
            'updated_at',
        ]);

        return DataTables::eloquent($guide)
        ->addColumn('icon',function ($p){
            if($p->guide_type_icon){
                return '<div class="text-center">
                <img src="/guide_types/'.$p->guide_type_icon.'" width="50px" height="50px" alt="'.$p->guide_type_icon.'" style=" fill: red; vertical-align: middle;">
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
            <a class="btnEditGuide btn-icon" data-toggle="modal" id="editButton" data-target="#editGuideModal" 
                value="'.$p->guide_type_id.'" class="btn btn-warning inline" >
                <i class="material-icons" style="color: #9c27b0;font-size:1.1rem;cursor: pointer;">edit</i>
                </a>
            <a class="btn-icon remove" id="'.$p->guide_type_id.'" >
            <i class="material-icons" style="color:#f44336;font-size:1.1rem;cursor: pointer;">close</i>
            </a>
            </td>';
        })
        ->rawColumns([
            'icon',
            'action'
        ])->toJson();
    }

    public function detailGuideType(Request $request)
    {
        $guide = GuideType::where('guide_type_id', $request->id)->get();
        return response()->json($guide);
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
            'guide_type_title' => ['required', 'string', 'min:2', 'unique:guide_types'],
            'guide_type_desc' => ['required', 'string', 'min:2'],
            // 'facility_order' => ['required', 'min:2'],
            'guide_type_icon' => ['required', 'image', 'mimes:svg'],
        ],
        [
            'guide_type_title.required' => 'Nama tipe panduan harus diisi.',
            'guide_type_title.string' => 'Nama tipe panduan harus berupa huruf.',
            'guide_type_title.min' => 'Nama tipe panduan tidak boleh kurang dari 2 karakter.',
            'guide_type_title.unique' => 'Nama tipe panduan sudah dipakai.',
            'guide_type_desc.required' => 'Deskripsi harus diisi.',
            'guide_type_desc.string' => 'Deskripsi harus berupa huruf.',
            'guide_type_desc.min' => 'Deskripsi tidak boleh kurang dari 2 karakter.',
            'guide_type_icon.required' => 'Gambar tipe panduan harus dimasukan.',
            'guide_type_icon.image' => 'Gambar tipe panduan harus berupa gambar.',
            'guide_type_icon.mimes' => 'Format gambar tipe panduan hanya berupa SVG.',

        ]);

        if ($request->hasFile('guide_type_icon')) {
            $file = $request->file('guide_type_icon');
            $filename = time() . Str::slug($request->guide_type_title) . '.' . $file->getClientOriginalExtension();
            $file->move('guide_types', $filename);
            // File::delete('categories/' . $category->category_icon);
            
            $iconFileName = $filename;

            $guideType = GuideType::create([
                'guide_type_title' => $request->guide_type_title,
                'guide_type_desc' => $request->guide_type_desc,
                'guide_type_icon' => $iconFileName,
            ]);

        }


        return redirect()->route('guide_type.index')->with(['success' => 'Tipe Panduan Baru Ditambahkan!']);
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
            'edit_guide_type_title' => ['required', 'string', 'min:2'],
            'edit_guide_type_desc' => ['required', 'string', 'min:2'],
            // 'facility_order' => ['required', 'min:2'],
            'edit_guide_type_icon' => ['nullable', 'image', 'mimes:svg'],
        ],
        [
            'edit_guide_type_title.required' => 'Nama tipe panduan harus diisi.',
            'edit_guide_type_title.string' => 'Nama tipe panduan harus berupa huruf.',
            'edit_guide_type_title.min' => 'Nama tipe panduan tidak boleh kurang dari 2 karakter.',
            // 'guide_type_title.unique' => 'Nama tipe panduan sudah dipakai.',
            'edit_guide_type_desc.required' => 'Deskripsi harus diisi.',
            'edit_guide_type_desc.string' => 'Deskripsi harus berupa huruf.',
            'edit_guide_type_desc.min' => 'Deskripsi tidak boleh kurang dari 2 karakter.',
            // 'guide_type_icon.required' => 'Gambar tipe panduan harus dimasukan.',
            'edit_guide_type_icon.image' => 'Gambar tipe panduan harus berupa gambar.',
            'edit_guide_type_icon.mimes' => 'Format gambar tipe panduan hanya berupa SVG.',

        ]);
        
        $guide = GuideType::find($id);
        $filename = $guide->guide_type_icon;
        
        if ($request->hasFile('edit_guide_type_icon')) {
            $file = $request->file('edit_guide_type_icon');
            $filename = time() . Str::slug($request->edit_guide_type_title) . '.' . $file->getClientOriginalExtension();
            $file->move('guide_types', $filename);
            File::delete('guide_types/' . $guide->guide_type_icon);
        }

        $iconFileName = $filename;

        $guide->update([
            'guide_type_title' => $request->edit_guide_type_title,
            'guide_type_desc' => $request->edit_guide_type_desc,
            'guide_type_icon' => $iconFileName,
        ]);

        return redirect()->route('guide_type.index')->with(['success' => 'Tipe Panduan Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guide = GuideType::withCount(['Guide'])->find($id);
        if ($guide->Guide_count == 0){
            $guide->is_deleted = true;
            $guide->save();
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}

