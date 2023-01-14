<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-categories')) return $next($request);

            abort(403, 'Anda tidak memiliki akses');
        });
    }
    
    public function index(Request $request)
    {
        $category = Category::paginate(10);
        $filterKeyword = $request->get('keyword');

        if($filterKeyword){
            $category = Category::where("name", "LIKE", "%$filterKeyword%")->paginate(10);
        }

        return view('categories.index',['categories' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');

        $validateData = $request->validate([
            'name' => 'required | min:3 | max:20',
			'image' => 'image|file|max:1024'
        ]);

        if($request->file('image')){
            $validateData['image'] = $request->file('image')->store('category_images', 'public');
        }

        $validateData['created_by'] = Auth::user()->id;

        $validateData['slug'] = Str::slug($name,'-');

        Category::create($validateData);

        return redirect()->route('categories.create')->with('status','Category successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show',['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $name = $request->get('name');
        $rules = [
            'name' => 'required | min:3 | max:20',
			'image' => 'image|file|max:1024'
        ];

        $validatedData = $request->validate($rules);

        
		if ($request->file('image')) {
			if ($category->image) {
				Storage::delete($category->image);
			}
			$validatedData['image'] = $request->file('image')->store('category_images','public');
		}
        $validatedData['created_by'] = Auth::user()->id;
        $validatedData['slug'] = Str::slug($name,'-');

        Category::where('id',$category->id)->update($validatedData);

        return redirect()->route('categories.edit', [$category->id])->with('status','Category succesfully update');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->image){
            Storage::delete($category->image);
        }

        Category::destroy($category->id);

        return redirect()->route('categories.index')->with('status','Category successfully deleted');
    }

    public function trash()
    {
        $category = Category::onlyTrashed()->paginate(10);

        return view('categories.trash',['categories' => $category]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if($category->trashed()){
            $category->restore();
        }else{
            return redirect()->route('categories.index')->with('status','Category is not in trash');
        }

        return redirect()->route('categories.index')->with('status','Category successfully restored');

    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if($category->image){
            Storage::delete('public/' . $category->image);
        }

        if(!$category->trashed()){
            return redirect()->route('categories.index')->with('status','Can not Delete permanent active Category');
        }else{
            $category->forceDelete();

            return redirect()->route('categories.index')->with('status','Category permanently deleted');
        }
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');

        $category = Category::where("name","LIKE","%$keyword%")->get();

        return $category;
    }
}
