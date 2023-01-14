<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-books')) return $next($request);

            abort(403, 'Anda tidak memiliki akses');
        });
    }
    
    public function index(Request $request)
    {
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        if($status){
            $books = Book::where('title',"LIKE","%$keyword%")->where('status',strtoupper($status))->paginate(10);
        }else{
            $books = Book::paginate(10);
        }

        return view('books.index', ['books'=> $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Book $book)
    {
        $validateData = $request->validate([
            'title' => 'required | min:5 | max:200',
            'description' => 'required',
            'author' => 'required |min:3 | max:100',
            'publisher' => 'required | min:3 | max:200',
            'price' => 'required | digits_between:0,10',
            'stock' => 'required | digits_between:0,10',
            'cover' => 'required|image|file|max:1024',
        ]);

        $validateData['status'] = $request->get('save_action');

        if($request->file('cover')){
            $validateData['cover'] = $request->file('cover')->store('book_covers', 'public');
        }

        $validateData['slug'] = Str::slug($validateData['title']);
        $validateData['created_by'] = Auth::user()->id;

        $book = new Book;
        $book = Book::create($validateData);

        $book->categories()->attach($request->get('categories'));
        
        if($request->get('save_action') == 'PUBLISH'){
            return redirect()->route('books.create')->with('status','Book Successfully saved and published');
        }else{
            return redirect()->route('books.create')->with('status','Book Successfully saved as Draft');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit',['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $rules = [
            'title' => 'required | min:5 | max:200',
            'description' => 'required',
            'author' => 'required |min:3 | max:100',
            'publisher' => 'required | min:3 | max:200',
            'price' => 'required | digits_between:0,10',
            'stock' => 'required | digits_between:0,10',
            'cover' => 'required | image|file|max:1024',
            'category' => 'required',
            'status' => 'required'
        ];

        $validatedData = $request->validate($rules);
        if($request->slug != $book->id){
            $rules['slug'] = 'required | unique:users';
        }

        if ($request->file('cover')) {
			if ($book->cover) {
				Storage::delete($book->cover);
			}
			$validatedData['cover'] = $request->file('cover')->store('book_covers','public');
		}

        $validatedData['created_by'] = Auth::user()->id;
        $validatedData['slug'] = Str::slug($request->get('title'),'-');

        Book::where('id',$book->id)->update($validatedData);

        $book->categories()->sync($request->get('categories'));
       
        return redirect()->route('books.edit', [$book->id])->with('status','Book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if($book->image){
            Storage::delete($book->image);
        }

        Book::destroy($book->id);

        return redirect()->route('books.index')->with('status','Book moved to trash');
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->paginate(10);

        return view('books.trash',['books' => $books]);
    }

    public function restore($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        if($book->trashed()){
            $book->restore();

            return redirect()->route('books.trash')->with('status','Book successfully restored');
        }else{
            return redirect()->route('books.trash')->with('status','Book is not in trash');
        }

    }

    public function deletePermanent($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        if($book->cover){
            Storage::delete('public/' . $book->cover);
        }

        if($book->trashed()){
            $book->categories()->detach();
            $book->forceDelete();

            return redirect()->route('books.trash')->with('status','Book successfully deleted');
        }else{
            return redirect()->route('books.trash')->with('status','Book is not in trash');
        }
    }
}
