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
    }
?>
