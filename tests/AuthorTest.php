<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Author::deleteAll();
        // }

        function testGetAuthorName()
        {
            $author_name = "The Little Prince";
            $test_author = new Author($author_name);

            $result = $test_author->getAuthorName();

            $this->assertEquals($author_name, $result);
        }

        function testSetAuthorName()
        {
            $author_name = "The Little Prince";
            $test_author = new Author($author_name);
            $new_author_name = "The Author of Laughter and Forgetting";

            $test_author->setAuthorName($new_author_name);
            $result = $test_author->getAuthorName();

            $this->assertEquals($new_author_name, $result);
        }

        function testSave()
        {
            $author_name = "The Unbearable Lightness of Being";
            $test_author = new Author($author_name);

            $executed = $test_author->save();

            $this->assertTrue($executed, "Author not successfully saved to database");
        }
        //
        // function testGetId()
        // {
        //     $author_name = "Clifford";
        //     $test_author = new Author($author_name);
        //     $test_author->save();
        //
        //     $result = $test_author->getId();
        //
        //     $this->assertEquals(true, is_numeric($result));
        //
        // }
        //
        // function testGetAll()
        // {
        //     $author_name_1 = "Secrets of the Talking Jaguar";
        //     $test_author_1 = new Author($author_name_1);
        //     $test_author_1->save();
        //
        //     $author_name_2 = "The Smell of Rain on Dust";
        //     $test_author_2 = new Author($author_name_2);
        //     $test_author_2->save();
        //
        //     $result = Author::getAll();
        //
        //     $this->assertEquals([$test_author_1, $test_author_2], $result);
        // }
        //
        // function testDeleteAll()
        // {
        //     $author_name_1 = "Secrets of the Talking Jaguar";
        //     $test_author_1 = new Author($author_name_1);
        //     $test_author_1->save();
        //
        //     $author_name_2 = "The Smell of Rain on Dust";
        //     $test_author_2 = new Author($author_name_2);
        //     $test_author_2->save();
        //
        //     Author::deleteAll();
        //     $result = Author::getAll();
        //
        //     $this->assertEquals([], $result);
        // }
        //
        // function testFind()
        // {
        //     $author_name_1 = "Secrets of the Talking Jaguar";
        //     $test_author_1 = new Author($author_name_1);
        //     $test_author_1->save();
        //
        //     $author_name_2 = "The Smell of Rain on Dust";
        //     $test_author_2 = new Author($author_name_2);
        //     $test_author_2->save();
        //
        //     $result = Author::find($test_author_2->getId());
        //
        //     $this->assertEquals($test_author_2, $result);
        // }
        //
        // function testUpdateAuthorName()
        // {
        //     $author_name = "The Little Prince";
        //     $test_author = new Author($author_name);
        //     $test_author->save();
        //     $new_author_name = "The Author of Laughter and Forgetting";
        //
        //     $test_author->updateAuthorName($new_author_name);
        //
        //     $this->assertEquals("The Author of Laughter and Forgetting", $test_author->getAuthorName());
        // }
        //
        // function testDelete()
        // {
        //     $author_name_1 = "Secrets of the Talking Jaguar";
        //     $test_author_1 = new Author($author_name_1);
        //     $test_author_1->save();
        //
        //     $author_name_2 = "The Smell of Rain on Dust";
        //     $test_author_2 = new Author($author_name_2);
        //     $test_author_2->save();
        //
        //     $test_author_1->delete();
        //
        //     $this->assertEquals([$test_author_2], Author::getAll());
        // }
    }
?>
