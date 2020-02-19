<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Book;
use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    private function data() {
        return [
            'title'=>'title',
            'author_id'=> 'Victor'
        ];
    }

     /** @test */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post(route('add-book'), $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

     /** @test */
    public function a_title_is_required() {

        $response = $this->post(route('add-book'), array_merge($this->data(), ['title'=>'']));

        $response->assertSessionHasErrors('title');

    }

     /** @test */
     public function an_author_is_required() {

        $response = $this->post(route('add-book'), array_merge($this->data(), ['author_id'=>'']));

        $response->assertSessionHasErrors('author_id');

    }

      /** @test */
      public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();

        $this->post(route('add-book'), $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(),
        [
            'title'=>'smith',
            'author_id'=> 'chris'
        ]);

        $this->assertEquals('smith', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());

    }

       /** @test */
    public function a_book_can_be_deleted() {

        $this->withoutExceptionHandling();

        $response = $this->post(route('add-book'), $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete(route('delete-book', ['book' => $book->id]));

        $this->assertCount(0, Book::all());

        $response->assertRedirect(route('get-books'));
    }

      /** @test */
    public function a_new_author_is_automatically_added() {

        $this->withExceptionHandling();
        $this->post(route('add-book'), [
            'title'=>'cool',
            'author_id'=> 'steve'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());


    }

}
