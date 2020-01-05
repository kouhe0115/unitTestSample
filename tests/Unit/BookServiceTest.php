<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use App\Services\BookService;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

    private $service;


    /**
     * 一番最初に動く
     */
    public function setUp()
    {
        parent::setUp();
        $this->service = app()->make(BookService::class);
    }

    /**
     * 指定のIDで本を取得できること
     * Book::classのフルパスを取得できる
     */
    public function testGetBookById()
    {
        $target = factory(Book::class)->create();
        $actual = $this->service->getBookById($target->id);

        // $this->assertTrue($actual->id === 1);
        $this->assertSame($target->id, $actual->id);
        // $this->assertSame($target->name, $actual->name);
    }

    /**
     * 本を一件新規作成できること
     */
    public function testCreateBook()
    {
        $this->service->createBook(['name' => '女神']);
        $actual = Book::all();
        
        $this->assertCount(1, $actual);
        $this->assertSame('女神', $actual->first()->name);
    }

    /**
     * 指定のIDで本の更新ができること
     */
    public function testUpdateBookById()
    {
        $target = factory(Book::class)->create(['name' => '天使']);
        $this->service->updateBookById($target->id, ['name' => '女神']);
        $actual = Book::find($target->id);

        $this->assertSame('女神', $actual->name);
    }

    /**
     * 指定のIDで本を一件削除出来ること
     */
    public function testDeleteBookById()
    {
        // ダミー
        factory(Book::class, 3)->create();
        $target = factory(Book::class)->create();
        $bef = Book::find($target->id);

        $this->assertNotNull($bef);

        $this->service->deleteBookById($target->id);
        $aft = Book::find($target->id);

        $this->assertNull($aft);
        $this->assertCount(3, Book::all());
    }
}
