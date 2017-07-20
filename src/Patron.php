<?php
    class Patron
    {
        private $patron_name;
        private $id;

        function __construct($patron_name, $id = null)
        {
            $this->patron_name = $patron_name;
            $this->id = $id;
        }

        function getPatronName()
        {
            return $this->patron_name;
        }

        function setPatronName($new_patron_name)
        {
            $this->patron_name = (string) $new_patron_name;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO patrons (patron_name) VALUES ('{$this->getPatronName()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
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
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons");
            $patrons = array();
            foreach($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $patron_id = $patron['id'];
                $new_patron = new Patron($patron_name, $patron_id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function find($search_id)
        {
            $returned_patrons = $GLOBALS['DB']->prepare("SELECT * FROM patrons WHERE id = :id");
            $returned_patrons->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_patrons->execute();
            foreach ($returned_patrons as $patron) {
                $patron_name = $patron['patron_name'];
                $patron_id = $patron['id'];
                if ($patron_id == $search_id) {
                    $returned_patron = new Patron($patron_name, $patron_id);
                }
            }
            return $returned_patron;
        }

        function updatePatronName($new_patron_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE patrons SET patron_name = '{$new_patron_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setPatronName($new_patron_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        // function addBook($book)
        // {
        //     $executed = $GLOBALS['DB']->exec("INSERT INTO patrons_books (patron_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
        //     if ($executed) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        //
        // function getBooks()
        // {
        //     $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM patrons JOIN patrons_books ON (patrons_books.patron_id = patron_id) JOIN books ON (books.id = patrons_books.book_id) WHERE patrons.id = {$this->getId()};");
        //     $books = array();
        //     foreach($returned_books as $book) {
        //         $title = $book['title'];
        //         $book_id = $book['id'];
        //         $new_book = new Book($title, $book_id);
        //         array_push($books, $new_book);
        //     }
        //     return $books;
        // }

        // static function findPatronByName($search_patron_name)
        // {
        //     $returned_patrons = $GLOBALS['DB']->prepare("SELECT * FROM patrons WHERE patron_name = :patron_name");
        //     $returned_patrons->bindParam(':patron_name', $search_patron_name, PDO::PARAM_STR);
        //     $returned_patrons->execute();
        //     foreach ($returned_patrons as $patron) {
        //         $patron_name = $patron['patron_name'];
        //         $patron_id = $patron['id'];
        //         if ($patron_name == $search_patron_name) {
        //             $returned_patron = new Patron($patron_name, $patron_id);
        //         }
        //     }
        //     return $returned_patron;
        // }

    }
?>
