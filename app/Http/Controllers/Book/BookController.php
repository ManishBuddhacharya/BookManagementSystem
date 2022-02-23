<?php
 
namespace App\Http\Controllers\Book;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repository\BookRepo;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function getAll(BookRepo $book_repo)
    {
        return $book_repo->all();
    }

    public function storeBook(Request $request, BookRepo $book_repo)
    {
        if(!auth()->user()->is_admin){
            return response(["message" => 'Not Autourized'], 401);
        }
        
        $this->validate($request, [
            'book_name' => ['required', 'string', 'max:255'],
            'author_name' => ['required', 'string'],
            'published_date' => 'required',
            'attachment' => 'sometimes|required|file|mimes:pdf',
        ]);
        
        $data = $request->except('token', 'attachment');
        
        DB::beginTransaction();
        try {
            if($request->attachment){
                $file_name = $book_repo->uploadFile($request->attachment);
                $data['attachment'] = $file_name;
            }
            $book = $book_repo->saveUpdate($data);
            DB::commit();
            return  response()->json(['message' => 'Book Created Succesfully', 'data' => $book], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage().$e->getLine().$e->getFile()], 500);
        }
    }

    public function updateBook(Request $request, $book, BookRepo $book_repo)
    {
        if(!auth()->user()->is_admin){
            return response(["message" => 'Not Autourized'], 401);
        }

        $this->validate($request, [
            'book_name' => ['required', 'string', 'max:255'],
            'author_name' => ['required', 'string'],
            'published_date' => 'required',
            'attachment' => 'sometimes|required|file|mimes:pdf',
        ]);
        
        $data = $request->except('token', 'attachment');
        
        DB::beginTransaction();
        try {
            if($request->attachment){
                $file_name = $book_repo->uploadFile($request->attachment);
                $data['attachment'] = $file_name;
            }
            $book = $book_repo->update($book, $data);
            DB::commit();
            return  response()->json(['message' => 'Book Updated Succesfully', 'data' => $book], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 500);
        }
    }

    public function deleteBook($book, BookRepo $book_repo)
    {   
        if(!auth()->user()->is_admin){
            return response(["message" => 'Not Autourized'], 401);
        }

        DB::beginTransaction();
        try {
            $book_repo->softDelete($book);
            DB::commit();
            return  response()->json(['message' => 'Book Deleted Succesfully'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $book, BookRepo $book_repo)
    {   
        if(!auth()->user()->is_admin){
            return response(["message" => 'Not Autourized'], 401);
        }

        DB::beginTransaction();
        try {
            $data = $book_repo->destroy($book);
            DB::commit();
            return  response()->json(['message' => 'Book Deleted Succesfully', 'data' => $data], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response(["message" => $e->getMessage()], 500);
        }
    }

    public function downloadBookAttachment($attachment)
    {
        $attachment = base64_decode($attachment);

        if(file_exists(storage_path('attachments/'.$attachment)))
            return response()->download(storage_path('attachments/'.$attachment));
            
        return response()->json(['message' => 'File not found']);
        
    }

}
