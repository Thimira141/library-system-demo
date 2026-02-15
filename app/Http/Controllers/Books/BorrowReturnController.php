<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BooksBorrowReturn;
use App\Models\Book;
use App\Models\Members;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BorrowReturnController extends Controller
{
    public function prepBookBorrowReturn(Request $request)
    {
        // code
        // read book_id, member_id
        // send the latest added book_borrowed record if u wanna return the book
        // if u want to borrow the book send the response saying book can be borrowed or not based on rules setup for the books and members
    }

    // borrow book
    public function BorrowBook(Request $request)
    {
        // validate data
        $validate = validator($request->all(), [
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrowed_date' => 'required|date',
            'return_promised_date' => 'required|date|after_or_equal:borrowed_date',
            'returned_date' => 'nullable|date|after_or_equal:borrowed_date',
            'remarks' => 'nullable|string',
        ], [
            // Custom messages
            'return_promised_date.after_or_equal' => 'Promised return date must be the same day or later than the borrowed date.',
        ], [
            // Attribute names
            'book_id' => 'Book ID',
            'member_id' => 'Member ID',
            'borrowed_date' => 'Borrowed Date',
            'return_promised_date' => 'Promised Return Date',
            'remarks' => 'Remarks',
        ]);
        // handle validate fail response
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        // store validated data
        try {
            BooksBorrowReturn::create($validate->validated());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
        // handle response
        return response()->json([
            'status' => 'success',
            'message' => 'Data Store Success!'
        ], 200);
    }

    // mark as returned book
    public function ReturnBook(Request $request)
    {
        // validate data
        $validate = validator($request->all(), [
            'id' => 'required|exists:book_borrow_return,id', // books_borrow_return.id
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'returned_date' => 'required|date|after_or_equal:borrowed_date',
            'remarks' => 'nullable|string',
        ], [
            'returned_date.after_or_equal' => 'Returned date must be the same day or later than the borrowed date.',
        ], [
            'id' => 'BBR_ID',
            'book_id' => 'Book ID',
            'member_id' => 'Member ID',
            'returned_date' => 'Returned Date',
            'remarks' => 'Remarks',
        ]);
        // handle validate fail response
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        // update data
        $validate = $validate->validated();
        try {
            $bbr = BooksBorrowReturn::where('id', $validate['id'])->firstOrFail();
            $bbr->returned_date = $validate['returned_date'];
            $bbr->remarks = $validate['remarks'];
            $bbr->save();
        } catch (\Exception $e) {
            return response()->json([
                    'status' => 'error',
                    'message' => 'Data update failed!.',
                    'error' => $e->getMessage()
                ], 500);
        }
        // handle success response
        return response()->json([
            'status' => 'success',
            'message' => 'Book returned successfully!',
            // 'redirect' => route('books.index')
        ], 200);
    }

    // query history, for books
    public function BookBorrowReturnHistory($book_id)
    {
        // code
        // get books.id -> send it to query_history('book_id', books.id)
    }

    // query history, for members
    public function MemberBorrowReturnHistory($member_id)
    {
        // code
        // get members.id -> send it to query_history('member_id', members.id)
    }

    protected function query_history($column, $value)
    {
        // code
    }

    protected function check_book_can_be_borrowed(string $book_id, string $member_id) {
        // check member can borrowed this book,
        // one member can only borrow n(n >= 1) amount of books
        // is the book already out or not
        // rule need to be set in future updates
        // * can member access this book, like book is 18+ or members need special privilege to access the book

    }
}
