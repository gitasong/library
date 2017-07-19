<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}')");
            if ($executed) {
                $this->id= $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        function getId()
        {
            return $this->id;
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach($returned_books as $book) {
                $book_title = $book['title'];
                $book_id = $book['id'];
                $new_book = new Book($book_title, $book_id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function find($search_id)
        {
            $returned_books = $GLOBALS['DB']->prepare("SELECT * FROM books WHERE id = :id");
            $returned_books->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_books->execute();
            foreach ($returned_books as $book) {
                $book_title = $book['title'];
                $book_id = $book['id'];
                if ($book_id == $search_id) {
                    $found_book = new Book($book_title, $book_id);
                }
            }
            return $found_book;
        }

        function updateTitle($new_title)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getID()};");
            if ($executed) {
                $this->setTitle($new_title);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getID()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }
    }



?>
