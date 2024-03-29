<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Categories;
use DB;
use Auth;

class CategoriesController extends Controller
{
    public function index()
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        $ldms_role_data = Role::where('id', $ldms_user_data->role_id)->first();
        
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($ldms_role_data->title == 'admin') {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();


             // $categories = Categories::where('parent', null)->orderby('name', 'asc')->get();


             $categories = Categories::where('parent', null)->orderby('name', 'asc')->get();
             $categories_main = Categories::pluck('is_main', 'id');   
            

            return view('categories.index', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'categories', 'categories_main'));
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'slug'      => 'required|unique:categories',
            'parent' => 'nullable|numeric'
        ]);

        $add = new Categories();
        $add->name = htmlspecialchars($request->name);
        $add->slug = htmlspecialchars($request->slug);
        $add->parent = $request->parent;
        $add->save();

        return redirect()->back()->with('message', 'Categoría Agregada');
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'slug'      => 'required|unique:categories',
            'parent' => 'nullable|numeric'
        ]);
        $update = Categories::find($request->id);

        $update->name = htmlspecialchars($request->name);
        $update->slug = htmlspecialchars($request->slug);
        $update->parent = $request->parent;
        $update->save();

        return redirect()->back()->with('message', 'Categoría Actualizada');
    }

    public function delete(Request $request)
    {
        $categories = Categories::find($request->category_id);
        $categories->delete();

        return redirect()->back()->with('message', 'Categoría Eliminada');
    }
   
   
     public function subCat($id)
    {
        $sub_categories = Categories::where('parent',$id)->get();

        $data = '<select name="category_id" class="category_choice form-control" style="margin-top:30px">';
        foreach ($sub_categories as $sub)
        {
            $data .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }
        $data .= '</select>';
        return response()->json(['data' => $data]);
    }
}