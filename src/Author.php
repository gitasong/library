<?php
    class Author
    {
        private $author_name;
        private $id;

        function __construct($author_name, $id = null)
        {
            $this->author_name = $author_name;
            $this->id = $id;
        }

        function getAuthorName()
        {
            return $this->author_name;
        }

        function setAuthorName($new_author_name)
        {
            $this->author_name = (string) $new_author_name;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO authors (author_name) VALUES ('{$this->getAuthorName()}')");
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
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();
            foreach($returned_authors as $author) {
                $author_author_name = $author['author_name'];
                $author_id = $author['id'];
                $new_author = new Author($author_author_name, $author_id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        static function find($search_id)
        {
            $returned_authors = $GLOBALS['DB']->prepare("SELECT * FROM authors WHERE id = :id");
            $returned_authors->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_authors->execute();
            foreach ($returned_authors as $author) {
                $author_author_name = $author['author_name'];
                $author_id = $author['id'];
                if ($author_id == $search_id) {
                    $returned_author = new Author($author_author_name, $author_id);
                }
            }
            return $returned_author;
        }

        function updateAuthorName($new_author_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE authors SET author_name = '{$new_author_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setAuthorName($new_author_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }
    }



?>
