<?php

namespace App\Http\Controllers;

use App\Books;
use App\Http\Middleware\TrimStrings;
use Illuminate\Http\Request;


use App\Http\Resources\Books as BooksResource;
use App\Http\Resources\BooksCollection as BooksCollection;


class BooksController extends Controller
{
    /**
     * Fetch all Books
     */
    public function index()
    {
        return new BooksResource(Books::all());
    }


    public function findBooksByTitle(Request $request)
    {
        return new BooksCollection(Books::where('title',$request->title)->get());
    }

    public function findBooksByIsbn(Request $request)
    {
        return new BooksCollection(Books::where('isbn',$request->isbn)->get());
    }

    public function generalSearch(Request $request){

          $searchString = $request->input;

        $report = Books::query()
            ->where('title', 'LIKE', "%{$searchString}%")
            ->orWhere('year', 'LIKE', "%{$searchString}%")
            ->orWhere('genre', 'LIKE', "%{$searchString}%")
            ->get();

        return $report;
    }


    public function reportTitles(){
        $report = Books::groupBy('title')
            ->selectRaw('count(*) as total, title')
            ->get();

        return $report;
    }
    public function reportYear(){
        $report = Books::groupBy('year')
            ->selectRaw('count(*) as total, year')
            ->get();

        return $report;
    }

    public function reportGenres(){
        $report = Books::groupBy('genre')
            ->selectRaw('count(*) as total, genre')
            ->get();

        return $report;
    }

    /**
     * Create a new book
     */
    public function create(Request $request)
    {
        $books = new Books;

        $books->title = $request->input('title');
        $books->author = $request->input('author');
        $books->genre = $request->input('genre');
        $books->year = $request->input('year');
        $books->isbn = $request->input('isbn');



        try {
            $books->save();


        }
        catch(\Illuminate\Database\QueryException $ex){
            $status = array('status'=>'fail');
            $msg['msg'] ='Please Contact The Adminstrator.';
            $data = array('error' => 'ERROR CODE BOOK-ADD' . $ex->getMessage());
            array_push($data, $msg,$status);
            return response()->json($data);

        } catch (PDOException $e) {
            $status = array('status'=>'fail');
            $msg['msg'] ='Please Contact The Adminstrator.';
            $data['error'] = 'ERROR CODE BOOK-ADD :' . $e->getMessage();
            array_push($data, $msg,$status);
            return response()->json($data);
        }

        $status=array('status'=>'success','book_id'=>$books->id);
        $data=array();
        array_push($data,$status);

        return response()->json($data);
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function show(Books $books)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function edit(Books $books)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Books $books)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy(Books $books)
    {
        //
    }
}
