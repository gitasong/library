<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
            Patron::deleteAll();
        }

        function testGetPatronName()
        {
            $patron_name = "Mary";
            $test_patron = new Patron($patron_name);

            $result = $test_patron->getPatronName();

            $this->assertEquals($patron_name, $result);
        }

        function testSetPatronName()
        {
            $patron_name = "John Doe";
            $test_patron = new Patron($patron_name);
            $new_patron_name = "Jane Doe";

            $test_patron->setPatronName($new_patron_name);
            $result = $test_patron->getPatronName();

            $this->assertEquals($new_patron_name, $result);
        }

        function testSave()
        {
            $patron_name = "Jimmy J";
            $test_patron = new Patron($patron_name);

            $executed = $test_patron->save();

            $this->assertTrue($executed, "Patron not successfully saved to database");
        }

        function testGetId()
        {
            $patron_name = "Clifford Big Red";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $result = $test_patron->getId();

            $this->assertEquals(true, is_numeric($result));

        }

        function testGetAll()
        {
            $patron_name_1 = "Nicole Freed";
            $test_patron_1 = new Patron($patron_name_1);
            $test_patron_1->save();

            $patron_name_2 = "Brittany Kerr";
            $test_patron_2 = new Patron($patron_name_2);
            $test_patron_2->save();

            $result = Patron::getAll();

            $this->assertEquals([$test_patron_1, $test_patron_2], $result);
        }

        function testDeleteAll()
        {
            $patron_name_1 = "Jacob Ruleaux";
            $test_patron_1 = new Patron($patron_name_1);
            $test_patron_1->save();

            $patron_name_2 = "Michelle Poterek";
            $test_patron_2 = new Patron($patron_name_2);
            $test_patron_2->save();

            Patron::deleteAll();
            $result = Patron::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $patron_name_1 = "Calla Rudolph";
            $test_patron_1 = new Patron($patron_name_1);
            $test_patron_1->save();

            $patron_name_2 = "Larry Taylor";
            $test_patron_2 = new Patron($patron_name_2);
            $test_patron_2->save();

            $result = Patron::find($test_patron_2->getId());

            $this->assertEquals($test_patron_2, $result);
        }

        function testUpdatePatronName()
        {
            $patron_name = "Dylan Lewis";
            $test_patron = new Patron($patron_name);
            $test_patron->save();
            $new_patron_name = "Max Scher";

            $test_patron->updatePatronName($new_patron_name);

            $this->assertEquals("Max Scher", $test_patron->getPatronName());
        }

        function testDelete()
        {
            $patron_name_1 = "Nathan Stewart";
            $test_patron_1 = new Patron($patron_name_1);
            $test_patron_1->save();

            $patron_name_2 = "Steve Spitz";
            $test_patron_2 = new Patron($patron_name_2);
            $test_patron_2->save();

            $test_patron_1->delete();

            $this->assertEquals([$test_patron_2], Patron::getAll());
        }

        function testAddBook()
        {
            $title = "Good Times";
            $test_book = new Book($title);
            $test_book->save();

            $patron_name = "Maya Angelou";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $test_patron->addBook($test_book);

            $this->assertEquals($test_patron->getBooks(), [$test_book]);
        }

        function testGetBooks()
        {
            $title = "Alice in Wonderland";
            $test_book = new Book($title);
            $test_book->save();

            $$title = "Ghostwriter";
            $test_book_2 = new Book($title);
            $test_book_2->save();

            $patron_name = "Richard Ford";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $test_patron->addBook($test_book);
            $test_patron->addBook($test_book_2);

            $this->assertEquals($test_patron->getBooks(), [$test_book, $test_book_2]);
        }

        // function testFindPatronByName()
        // {
        //     $patron_name_1 = "Carrie Fischer";
        //     $test_patron_1 = new Patron($patron_name_1);
        //     $test_patron_1->save();
        //
        //     $patron_name_2 = "George Clooney";
        //     $test_patron_2 = new Patron($patron_name_2);
        //     $test_patron_2->save();
        //
        //     $result = Patron::findPatronByName($test_patron_2->getPatronName());
        //
        //     $this->assertEquals($test_patron_2, $result);
        // }

    }
?>
