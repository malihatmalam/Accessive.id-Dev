<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Category;
use App\CategoryType;
use App\Account;
use DataTables;
use Redirect;
use Illuminate\Support\Str;
// FILE
use File;

class CategoryTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(['role:admin']);

    }

    public function indexData() // Datatable Index
    {
        // $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        $categoryType = CategoryType::where('is_deleted', false )->select([
            'category_type_id',
            'category_type_title',
            'created_at',
            'updated_at',
        ]);

        return DataTables::eloquent($categoryType)
        ->addColumn('action',function ($p){
            return '<td class:"text-center">
            <a class="btnEditCategoryType btn-icon" data-toggle="modal" id="editButton" data-target="#editCategoryTypeModal" 
                value="'.$p->category_type_id.'" class="btn btn-warning inline" >
                <i class="material-icons" style="color: #9c27b0;font-size:1.1rem;cursor: pointer;">edit</i>
                </a>
            <a class="btn-icon remove" id="'.$p->category_type_id.'" >
            <i class="material-icons" style="color:#f44336;font-size:1.1rem;cursor: pointer;">close</i>
            </a>
            </td>';
        })
        ->rawColumns([
            'action'
        ])->toJson();
    }

    public function detailCategoryType(Request $request)
    {
        $categoryType = CategoryType::where('category_type_id', $request->id)->get();
        return response()->json($categoryType);
    }

    public function test($id)
    {
        $categoryType = CategoryType::withCount(['category'])->find($id);
        if ($categoryType->category_count == 0){
            $categoryType->is_deleted = 1;
            $categoryType->save();
            return response()->json([
                'success' => 'Tipe Kategori Berhasil Dihapus!'
            ]);
        }
        return response()->json([
            'error' => 'Tipe Kategori Masih Memiliki Data Kategori!'
        ]);
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
            'category_type_title' => ['required', 'string', 'min:2', 'unique:category_types'],
        ],
        [
            'category_type_title.required' => 'Nama tipe kategori harus diisi.',
            'category_type_title.string' => 'Nama tipe kategori harus berupa huruf.',
            'category_type_title.min' => 'Nama tipe kategori tidak boleh kurang dari 3 karakter.',
            'category_type_title.unique' => 'Nama tipe kategori sudah dipakai.',
        ]);

        $categoryType = CategoryType::create([
            'category_type_title' => $request->category_type_title,
            'is_deleted' => false,
        ]);

        return redirect()->route('category.index')->with(['success' => 'Tipe Kategori Baru Ditambahkan!']);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'edit_category_type_title' => ['required', 'string', 'min:2', 'unique:category_types,category_type_title'],
        ],
        [
            'edit_category_type_title.required' => 'Nama tipe kategori harus diisi.',
            'edit_category_type_title.string' => 'Nama tipe kategori harus berupa huruf.',
            'edit_category_type_title.min' => 'Nama tipe kategori tidak boleh kurang dari 2 karakter.',
            'edit_category_type_title.unique' => 'Nama tipe kategori sudah dipakai.',
        ]);

        $categoryType = CategoryType::find($id);
        $categoryType->update([
            'category_type_title' => $request->edit_category_type_title,
        ]);

        return redirect()->route('category.index')->with(['success' => 'Tipe Kategori Sudah Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryType = CategoryType::withCount(['category'])->find($id);
        if ($categoryType->category_count == 0){
            $categoryType->is_deleted = 1;
            $categoryType->save();
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
        
    }
}
