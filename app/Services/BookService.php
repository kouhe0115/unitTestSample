<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    private $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getBookById($id)
    {
        return $this->book->find($id);
    }

    public function createBook($attributes)
    {
        $this->book->fill($attributes)->save();
    }

    public function updateBookById($id, $attributes)
    {
        $this->book->where('id', $id)->update($attributes);
    }

    public function deleteBookById($id)
    {
        $this->book->destroy($id);
    }
}
