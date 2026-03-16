<?php

use App\Models\Book;
use App\Models\Members;
use App\Models\BooksBorrowReturn;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BorrowReturnControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * Tests borrowing and returning BOOK-A for MEMBER-A
     * @return void
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function test_borrowing_and_returning_book_a_for_member_a()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create book and member
        $book = Book::factory()->create(['book_id' => 'BOOK-A']);
        $member = Members::factory()->create(['member_id' => 'MEMBER-A']);

        // Step 1: Prep
        $response = $this->getJson("/bbr/check-bbr-prep?book_id={$book->book_id}&member_id={$member->member_id}");
        $response->assertStatus(200);
        // dd($response->json());
        // $response->dd();

        // Step 2: Borrow
        $borrowResponse = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $member->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow'
        ]);
        $borrowResponse->assertStatus(200);
        // dd($borrowResponse->json());
        // $borrowResponse->dd();

        // Step 3: Database check
        $this->assertDatabaseHas('books_borrow_return', [
            'book_id' => $book->id,
            'member_id' => $member->id,
            'returned_date' => null
        ]);

        // Step 4: Prep again
        $response2 = $this->getJson("/bbr/check-bbr-prep?book_id={$book->book_id}&member_id={$member->member_id}");
        $response2->assertStatus(200);
        // dd($response2->json());
        // $response2->dd();

        // Step 5: Return
        $record = BooksBorrowReturn::where('book_id', $book->id)->where('member_id', $member->id)->first();
        $returnResponse = $this->postJson('/bbr/return-book', [
            'transaction_id' => $record->transaction_id,
            'book_id' => $book->book_id,
            'member_id' => $member->member_id,
            'returned_date' => now()->addDays(5)->format('Y-m-d'),
            'remarks' => 'Test return'
        ]);
        $returnResponse->assertStatus(200);
        // dd($returnResponse->json());
        // $returnResponse->dd();

        // Step 6: Verify returned
        $this->assertDatabaseHas('books_borrow_return', [
            'book_id' => $book->id,
            'member_id' => $member->id,
            'returned_date' => now()->addDays(5)->format('Y-m-d')
        ]);
    }

    /**
     * Tests borrowing BOOK-A for MEMBER-B and MEMBER-C, then returning
     * @return void
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function test_borrowing_book_a_for_member_b_and_member_c_then_returning()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create book and members
        $book = Book::factory()->create(['book_id' => 'BOOK-A']);
        $memberB = Members::factory()->create(['member_id' => 'MEMBER-B']);
        $memberC = Members::factory()->create(['member_id' => 'MEMBER-C']);

        // Borrow for MEMBER-B
        $borrowB = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberB->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow B'
        ]);
        $borrowB->assertStatus(200)->assertJson(['status' => 'success']);

        // Borrow for MEMBER-C (should fail because book is borrowed)
        $borrowC = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberC->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow C'
        ]);
        $borrowC->assertStatus(422)->assertJson(['status' => 'error', 'message' => 'Book is already borrowed']);

        // Return for MEMBER-B
        $recordB = BooksBorrowReturn::where('book_id', $book->id)->where('member_id', $memberB->id)->first();
        $returnB = $this->postJson('/bbr/return-book', [
            'transaction_id' => $recordB->transaction_id,
            'book_id' => $book->book_id,
            'member_id' => $memberB->member_id,
            'returned_date' => now()->addDays(5)->format('Y-m-d'),
            'remarks' => 'Test return B'
        ]);
        $returnB->assertStatus(200)->assertJson(['status' => 'success']);

        // Now borrow for MEMBER-C (should succeed)
        $borrowC2 = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberC->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow C after return'
        ]);
        $borrowC2->assertStatus(200)->assertJson(['status' => 'success']);

        // Return for MEMBER-C
        $recordC = BooksBorrowReturn::where('book_id', $book->id)->where('member_id', $memberC->id)->first();
        $returnC = $this->postJson('/bbr/return-book', [
            'transaction_id' => $recordC->transaction_id,
            'book_id' => $book->book_id,
            'member_id' => $memberC->member_id,
            'returned_date' => now()->addDays(5)->format('Y-m-d'),
            'remarks' => 'Test return C'
        ]);
        $returnC->assertStatus(200)->assertJson(['status' => 'success']);
    }

    /**
     * Tests borrowing BOOK-B for MEMBER-A, MEMBER-B, and MEMBER-C, then returning
     * @return void
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function test_borrowing_book_b_for_member_a_member_b_and_member_c_then_returning()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create book and members
        $book = Book::factory()->create(['book_id' => 'BOOK-B']);
        $memberA = Members::factory()->create(['member_id' => 'MEMBER-A']);
        $memberB = Members::factory()->create(['member_id' => 'MEMBER-B']);
        $memberC = Members::factory()->create(['member_id' => 'MEMBER-C']);

        // Borrow for MEMBER-A
        $borrowA = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberA->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow A'
        ]);
        $borrowA->assertStatus(200)->assertJson(['status' => 'success']);

        // Borrow for MEMBER-B (should fail)
        $borrowB = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberB->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow B'
        ]);
        $borrowB->assertStatus(422)->assertJson(['status' => 'error', 'message' => 'Book is already borrowed']);

        // Return for MEMBER-A
        $recordA = BooksBorrowReturn::where('book_id', $book->id)->where('member_id', $memberA->id)->first();
        $returnA = $this->postJson('/bbr/return-book', [
            'transaction_id' => $recordA->transaction_id,
            'book_id' => $book->book_id,
            'member_id' => $memberA->member_id,
            'returned_date' => now()->addDays(5)->format('Y-m-d'),
            'remarks' => 'Test return A'
        ]);
        $returnA->assertStatus(200)->assertJson(['status' => 'success']);

        // Borrow for MEMBER-B (now should succeed)
        $borrowB2 = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberB->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow B after return'
        ]);
        $borrowB2->assertStatus(200)->assertJson(['status' => 'success']);

        // Borrow for MEMBER-C (should fail)
        $borrowC = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberC->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow C'
        ]);
        $borrowC->assertStatus(422)->assertJson(['status' => 'error', 'message' => 'Book is already borrowed']);

        // Return for MEMBER-B
        $recordB = BooksBorrowReturn::where('book_id', $book->id)->where('member_id', $memberB->id)->first();
        $returnB = $this->postJson('/bbr/return-book', [
            'transaction_id' => $recordB->transaction_id,
            'book_id' => $book->book_id,
            'member_id' => $memberB->member_id,
            'returned_date' => now()->addDays(5)->format('Y-m-d'),
            'remarks' => 'Test return B'
        ]);
        $returnB->assertStatus(200)->assertJson(['status' => 'success']);

        // Borrow for MEMBER-C (now should succeed)
        $borrowC2 = $this->postJson('/bbr/borrow-book', [
            'book_id' => $book->book_id,
            'member_id' => $memberC->member_id,
            'borrowed_date' => now()->format('Y-m-d'),
            'return_promised_date' => now()->addDays(7)->format('Y-m-d'),
            'remarks' => 'Test borrow C after return'
        ]);
        $borrowC2->assertStatus(200)->assertJson(['status' => 'success']);

        // Return for MEMBER-C
        $recordC = BooksBorrowReturn::where('book_id', $book->id)->where('member_id', $memberC->id)->first();
        $returnC = $this->postJson('/bbr/return-book', [
            'transaction_id' => $recordC->transaction_id,
            'book_id' => $book->book_id,
            'member_id' => $memberC->member_id,
            'returned_date' => now()->addDays(5)->format('Y-m-d'),
            'remarks' => 'Test return C'
        ]);
        $returnC->assertStatus(200)->assertJson(['status' => 'success']);
    }
}
