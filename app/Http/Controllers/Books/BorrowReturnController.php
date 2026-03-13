<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BooksBorrowReturn;
use App\Models\Book;
use App\Models\Members;
use Illuminate\Support\Facades\Validator;

class BorrowReturnController extends Controller
{
    /**
     * validate inputs, check whether the request is a borrow or return, and respond with JSON
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function prepBookBorrowReturn(Request $request)
    {
        // read book_id, member_id
        $validate = Validator::make(
            $request->all(),
            [
                'book_id' => 'required|string|exists:books,book_id',
                'member_id' => 'required|string|exists:members,member_id'
            ],
            [],
            ['book_id' => 'Book ID', 'member_id' => 'Member ID']
        );
        // handle validate fail response
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }

        $validated = $validate->validated();
        // decide is this for borrow book or return bok/extend period
        try {
            // check data exists
            $book = Book::where('book_id', $validated['book_id'])->first(['id', 'book_id']);
            $member = Members::where('member_id', $validated['member_id'])->first(['id', 'member_id']);
            if (!$book) {
                return response()->json(['status' => 'error', 'message' => 'Book not found'], 404);
            }
            if (!$member) {
                return response()->json(['status' => 'error', 'message' => 'Member not found'], 404);
            }
            // check for an existing BooksBorrowReturn record with returned_date = null
            $record = BooksBorrowReturn::where('book_id', $book->id)
                ->where('member_id', $member->id)->whereNull('returned_date')->first();
            // If found, you treat it as a return/extend.
            // If not found, you call check_book_can_be_borrowed() to see if borrowing is possible.
            $can_borrow = !$record ? $this->check_book_can_be_borrowed($book->book_id, $member->member_id) : false;
            // return response
            return response()->json([
                'status' => 'success',
                'can_borrow' => $can_borrow ? $can_borrow['status'] : false,
                'message' => $can_borrow ? $can_borrow['message'] : 'Action: Return Book / Extend Period',
                'record' => $record ? $record->toArray() : null,
                'similar_transactions' => BooksBorrowReturn::where('book_id', $book->id)
                    ->where('member_id', $member->id)->limit(10)->orderBy('id', 'desc')
                    ->get(['transaction_id', 'returned_date', 'borrowed_date', 'return_promised_date'])
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!, Error Code: ' . (string) $e->getCode(),
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Summary of BorrowBook
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function BorrowBook(Request $request)
    {
        // validate data
        $validate = Validator::make($request->all(), [
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
        $validate = Validator::make($request->all(), [
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

    /**
     * Summary of check_book_can_be_borrowed
     * @param string $book_id books.book_id
     * @param string $member_id members.member_id
     * @return array{status:bool, message:string}
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    protected function check_book_can_be_borrowed(string $book_id, string $member_id)
    {
        // member model
        $member = Members::where('member_id', $member_id)->first(['id']);
        if (!$member) {
            return ['status' => false, 'message' => 'Member not found'];
        }
        // book model
        $book = Book::where('book_id', $book_id)->first(['id']);
        if (!$book) {
            return ['status' => false, 'message' => 'Book not found'];
        }
        // check member can borrowed this book,
        // one member can only borrow n(n >= 1) amount of books
        if ($member->borrowRecords()->whereNull('returned_date')->count() <= 10) {
            return ['status' => false, 'message' => 'Member has reached borrow limit'];
        }
        // is the book already out or not
        if ($book->borrowRecords()->whereNull('returned_date')->exists()) {
            return ['status' => false, 'message' => 'Book is already borrowed'];
        }
        // rule need to be set in future updates
        // * can member access this book, like book is 18+ or members need special privilege to access the book

        // finally all conditions clear
        return ['status' => true, 'message' => 'Book can be borrowed'];

    }
}
