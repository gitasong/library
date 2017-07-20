<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('all_books' => Book::getAll(), 'all_authors' => Author::getAll()));
    });

    $app->post("/add_book", function() use ($app) {
        $title = $_POST['title'];
        $new_book = new Book($title);
        $new_book->save();
        return $app['twig']->render('index.html.twig', array('all_books' => Book::getAll()));
    });

    $app->get("/edit_book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('edit_book.html.twig', array('book' => $book));
    });

    $app->patch("/edit_book/{id}", function($id) use ($app) {
        $title  = $_POST['title'];
        $book = Book::find($id);
        $book->updateTitle($title);
        return $app['twig']->render('edit_book.html.twig', array('book' => $book));
    });

    $app->delete("/delete_book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app['twig']->render('index.html.twig', array('all_books' => Book::getAll()));
    });

    $app->post("/add_author", function() use ($app) {
        $author_name = $_POST['author_name'];
        $new_author = new Author($author_name);
        $new_author->save();
        return $app['twig']->render('index.html.twig', array('all_books' => Book::getAll(), 'all_authors' => Author::getAll()));
    });

    $app->get("/edit_author/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('edit_author.html.twig', array('author' => $author));
    });

    $app->patch("/edit_author/{id}", function($id) use ($app) {
        $author_name  = $_POST['author_name'];
        $author = Author::find($id);
        $author->updateAuthorName($author_name);
        return $app['twig']->render('edit_author.html.twig', array('author' => $author));
    });

    $app->delete("/delete_author/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $author->delete();
        return $app['twig']->render('index.html.twig', array('all_books' => Book::getAll(), 'all_authors' => Author::getAll()));
    });

    return $app;
?>
