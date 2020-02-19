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

        $response = $this->post('/books', [
            'title'=>'title',
            'author'=> 'Victor'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());

    }

     /** @test */
    public function a_title_is_required() {

        $response = $this->post('/books', [
            'title'=>'',
            'author'=> 'Victor'
        ]);

        $response->assertSessionHasErrors('title');

    }

     /** @test */
     public function an_author_is_required() {

        $response = $this->post('/books', [
            'title'=>'cool',
            'author'=> ''
        ]);

        $response->assertSessionHasErrors('author');

    }

      /** @test */
      public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();

         $this->post('/books', [
            'title'=>'cool',
            'author'=> 'steve'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id,[
            'title'=>'smith',
            'author'=> 'chris'
        ]);

        $this->assertEquals('smith', Book::first()->title);
        $this->assertEquals('chris', Book::first()->author);


    }


}
