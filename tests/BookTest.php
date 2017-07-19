<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
        }

        function testGetTitle()
        {
            $title = "The Little Prince";
            $test_book = new Book($title);

            $result = $test_book->getTitle();

            $this->assertEquals($title, $result);
        }

        function testSetTitle()
        {
            $title = "The Little Prince";
            $test_book = new Book($title);
            $new_title = "The Book of Laughter and Forgetting";

            $test_book->setTitle($new_title);
            $result = $test_book->getTitle();

            $this->assertEquals($new_title, $result);
        }

        function testSave()
        {
            $title = "The Unbearable Lightness of Being";
            $test_book = new Book($title);

            $executed = $test_book->save();

            $this->assertTrue($executed, "Book not successfully saved to database");
        }

        function testGetId()
        {
            $title = "Clifford";
            $test_book = new Book($title);
            $test_book->save();

            $result = $test_book->getId();

            $this->assertEquals(true, is_numeric($result));

        }

        function testGetAll()
        {
            $title_1 = "Secrets of the Talking Jaguar";
            $test_book_1 = new Book($title_1);
            $test_book_1->save();

            $title_2 = "The Smell of Rain on Dust";
            $test_book_2 = new Book($title_2);
            $test_book_2->save();

            $result = Book::getAll();

            $this->assertEquals([$test_book_1, $test_book_2], $result);
        }

        function testDeleteAll()
        {
            $title_1 = "Secrets of the Talking Jaguar";
            $test_book_1 = new Book($title_1);
            $test_book_1->save();

            $title_2 = "The Smell of Rain on Dust";
            $test_book_2 = new Book($title_2);
            $test_book_2->save();

            Book::deleteAll();
            $result = Book::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $title_1 = "Secrets of the Talking Jaguar";
            $test_book_1 = new Book($title_1);
            $test_book_1->save();

            $title_2 = "The Smell of Rain on Dust";
            $test_book_2 = new Book($title_2);
            $test_book_2->save();

            $result = Book::find($test_book_2->getId());

            $this->assertEquals($test_book_2, $result);
        }

        function testUpdateTitle()
        {
            $title = "The Little Prince";
            $test_book = new Book($title);
            $test_book->save();
            $new_title = "The Book of Laughter and Forgetting";

            $test_book->updateTitle($new_title);

            $this->assertEquals("The Book of Laughter and Forgetting", $test_book->getTitle());
        }

        function testDelete()
        {
            $title_1 = "Secrets of the Talking Jaguar";
            $test_book_1 = new Book($title_1);
            $test_book_1->save();

            $title_2 = "The Smell of Rain on Dust";
            $test_book_2 = new Book($title_2);
            $test_book_2->save();

            $test_book_1->delete();

            $this->assertEquals([$test_book_2], Book::getAll());
        }

        function testAddAuthor()
        {
            $author_name = "Computer Science";
            $test_author = new Author($author_name);
            $test_author->save();

            $title = "Ryan";
            $test_book = new Book($title);
            $test_book->save();

            $test_book->addAuthor($test_author);
            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function testGetAuthors()
        {
            $author_name = "G.G. Marquez";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name_2 = "Isabel Allende";
            $test_author_2 = new Author($author_name_2);
            $test_author_2->save();

            $title = "Who is the Who?";
            $test_book = new Book($title);
            $test_book->save();

            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author_2);
            $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author_2]);
        }

        function testFindBookByTitle()
        {
            $title_1 = "Secrets of the Talking Jaguar";
            $test_book_1 = new Book($title_1);
            $test_book_1->save();

            $title_2 = "The Smell of Rain on Dust";
            $test_book_2 = new Book($title_2);
            $test_book_2->save();

            $result = Book::findBookByTitle($test_book_2->getTitle());

            $this->assertEquals($test_book_2, $result);
        }
    }
?>
