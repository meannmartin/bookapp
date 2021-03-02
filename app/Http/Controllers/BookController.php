<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //index
    public function index()
    {
        $books = Book::latest()->get();
        return response([
            'success' => true,
            'message' => 'List of All Books',
            'data' => $books
        ], 200);
    }



    //create
    //store   
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'author'   => 'required',
            'datepublished'   => 'required',
        ],
            [
                'title.required' => 'Enter Title Post! ',
                'author.required' => 'Enter Content Post !',
                'datepublished.required' => 'Enter Content Date !',
            ]
        );
if($validator->fails()) {
return response()->json([
                'success' => false,
                'message' => 'Please fill in the blank fields',
                'data'    => $validator->errors()
            ],400);
} else {
$book = Book::create([
                'title'     => $request->input('title'),
                'author'   => $request->input('author'),
                'datepublished'   => $request->input('datepublished')
            ]);
if ($book) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Saved Saved! ',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Failed to Save!',
                ], 400);
            }
        }
    }

    //edit
    //update
    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'author'   => 'required',
            'datepublished'   => 'required',
        ],
            [
                'title.required' => 'Enter Title!',
                'author.required' => 'Enter Author !',
                'datepublished.required' => 'Enter Date Published!',
            ]
        );
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in the blank fields',
                'data'    => $validator->errors()
            ],400);
        } else {
            $book = Book::whereId($request->input('id'))->update([
                'title'     => $request->input('title'),
                'author'   => $request->input('author'),
                'datepublished'   => $request->input('datepublished')
            ]);
            if ($book) {
                return response()->json([
                    'success' => true,
                    'message' => 'Book Updated successfully!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Book Failed to Update!',
                ], 500);
            }
        }
    }

    //show
    public function show($id)
    {
        $book = Book::whereId($id)->first();
        if ($book) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Book!',
                'data'    => $book
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Book Not Found!',
                'data'    => ''
            ], 404);
        }
    }
    //destroy
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        if ($book) {
            return response()->json([
                'success' => true,
                'message' => 'Book Successfully Deleted!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Book Failed to Delete!',
            ], 500);
        }
    }
}
