<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post(route('add-book'), [
            'title'=>'title',
            'author'=> 'Victor'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

     /** @test */
    public function a_title_is_required() {

        $response = $this->post(route('add-book'), [
            'title'=>'',
            'author'=> 'Victor'
        ]);

        $response->assertSessionHasErrors('title');

    }

     /** @test */
     public function an_author_is_required() {

        $response = $this->post(route('add-book'), [
            'title'=>'cool',
            'author'=> ''
        ]);

        $response->assertSessionHasErrors('author');

    }

      /** @test */
      public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();

        $this->post(route('add-book'), [
            'title'=>'cool',
            'author'=> 'steve'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(),
        [
            'title'=>'smith',
            'author'=> 'chris'
        ]);

        $this->assertEquals('smith', Book::first()->title);
        $this->assertEquals('chris', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());

    }

       /** @test */
       public function a_book_can_be_deleted() {

        $this->withoutExceptionHandling();

        $response = $this->post(route('add-book'), [
            'title'=>'cool',
            'author'=> 'Victor'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete(route('delete-book', ['book' => $book->id]));

        $this->assertCount(0, Book::all());

        $response->assertRedirect(route('get-books'));
    }

}
