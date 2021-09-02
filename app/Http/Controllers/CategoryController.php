<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Category;
use App\CategoryType;
use App\Account;
use Redirect;
use DataTables;
use Illuminate\Support\Str;
// FILE
use File;

class CategoryController extends Controller
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
        $category = Category::where('is_deleted',false)->with('categoryType')->orderBy('created_at', 'DESC')->get();
        $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        return view('admin.category', compact('category','categoryType'));
    }

    public function indexData() // Datatable Index
    {
        // $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        $category = Category::where('is_deleted', false )->select([
            'category_id',
            'category_title',
            'category_icon',
            'created_at',
            'updated_at',
        ]);

        return DataTables::eloquent($category)
        ->addColumn('icon',function ($p){
            return '<div class="text-center">
            <img src="/categories/'.$p->category_icon.'" width="80px" height="80px" alt="'.$p->category_icon.'">
            </div>';
        })
        ->addColumn('action',function ($p){
            return '<td class:"text-center">
            <a class="btnEditCategory btn-icon" data-toggle="modal" id="editButton" data-target="#editCategoryModal" 
                value="'.$p->category_id.'" parent="'.$p->category_type_id.'" class="btn btn-warning inline" >
                <i class="material-icons" style="color: #9c27b0;font-size:1.1rem;cursor: pointer;">edit</i>
                </a>
            <a class="btn-icon remove-category" id="'.$p->category_id.'" >
            <i class="material-icons" style="color:#f44336;font-size:1.1rem;cursor: pointer;">close</i>
            </a>
            </td>';
        })
        ->rawColumns([
            'icon',
            'action'
        ])->toJson();
    }

    public function detailCategory(Request $request)
    {
        $category = Category::where('category_id', $request->id)->get();
        return response()->json($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryType = CategoryType::where('is_deleted',false)->orderBy('category_type_title', 'ASC')->get();
        return view('admin.category_create', compact('categoryType'));
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
            'category_title' => ['required', 'string', 'min:2', 'unique:categories'],
            'category_icon' => ['required', 'image', 'mimes:png,jpeg,jpg,svg'],
        ],
        [
            'category_title.required' => 'Nama kategori harus diisi.',
            'category_title.string' => 'Nama kategori harus berupa huruf.',
            'category_title.min' => 'Nama kategori tidak boleh kurang dari 3 karakter.',
            'category_title.unique' => 'Nama kategori sudah dipakai.',
            'category_icon.required' => 'Gambar kategori harus dimasukan.',
            'category_icon.image' => 'Gambar kategori harus berupa gambar.',
            'category_icon.mimes' => 'Format gambar kategori hanya berupa PNG, JPEG, SVG dan JPG.',

        ]);

        if ($request->hasFile('category_icon')) {
            $file = $request->file('category_icon');
            $filename = time() . Str::slug($request->category_title) . '.' . $file->getClientOriginalExtension();
            $file->move('categories', $filename);
            // File::delete('categories/' . $category->category_icon);
            
            $iconFileName = $filename;
    
            $categoryType = Category::create([
                'category_title' => $request->category_title,
                'category_icon' => $iconFileName,
                'category_type_id' => $request->category_type_id
            ]);

        }


        return redirect()->route('category.index')->with(['success' => 'Kategori Baru Ditambahkan!']);
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
            'edit_category_title' => ['required', 'string', 'min:2'],
            'edit_category_icon' => ['nullable','image', 'mimes:png,jpeg,jpg,svg'],
        ],
        [
            'edit_category_title.required' => 'Nama kategori harus diisi.',
            'edit_category_title.string' => 'Nama kategori harus berupa huruf.',
            'edit_category_title.min' => 'Nama kategori tidak boleh kurang dari 3 karakter.',
            'edit_category_icon.image' => 'Gambar kategori harus berupa gambar.',
            'edit_category_icon.mimes' => 'Format gambar kategori hanya berupa PNG, JPEG, SVG dan JPG.',

        ]);

        $category = Category::find($id);
        $filename = $category->category_icon;

        if ($request->hasFile('edit_category_icon')) {
            $file = $request->file('edit_category_icon');
            $filename = time() . Str::slug($request->category_title) . '.' . $file->getClientOriginalExtension();
            $file->move('categories', $filename);
            File::delete('categories/' . $category->category_icon);
        }

        $iconFileName = $filename;

        $category->update([
            'category_title' => $request->edit_category_title,
            'category_icon' => $iconFileName,
            'category_type_id' => $request->edit_category_type_id
        ]);

        return redirect()->route('category.index')->with(['success' => 'Kategori Berhasil Diperbaharui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::withCount(['Place'])->find($id);
        if ($category->Place_count == 0){
            $category->is_deleted = true;
            $category->save();
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);
    }
}
