<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/librarian", function() use ($app) {
        return $app['twig']->render('librarian.html.twig', array('all_books' => Book::getAll(), 'all_authors' => Author::getAll()));
    });

    $app->get("/patron", function() use ($app) {
        return $app['twig']->render('patrons.html.twig', array('all_patrons' => Patron::getAll()));
    });

    $app->post("/add_patron", function() use ($app) {
        $patron_name = $_POST['patron_name'];
        $new_patron = new Patron($patron_name);
        $new_patron->save();
        return $app['twig']->render('patrons.html.twig', array('patron' => $new_patron, 'all_patrons' => Patron::getAll()));
    });

    $app->get("/patron/{id}", function($id) use ($app) {
        $patron = Patron::find($id);
        return $app['twig']->render('patron.html.twig', array('patron' => $patron, 'all_books' => Book::getAll(), 'checked_out_books' => Book::getAll()));  // change 'checked_out_books' => Book::getAll to patron->getBooks()
    });

    $app->post("/checkout_book/{id}", function($id) use ($app) {
        $patron = Patron::find($id);
        $book = Book::find($_POST['all_books']);
        $patron->addBook($book); // need this function
        return $app['twig']->render('patron.html.twig', array('patron' => $patron, 'all_books' => Book::getAll(), 'checked_out_books' => $patron->getBooks()));
    });

    $app->post("/search_by_title", function() use ($app) {
        $book_title = $_POST['book_title'];
        $found_book = Book::findBookByTitle($book_title);
        return $app['twig']->render('edit_book.html.twig', array('book' => $found_book, 'all_authors' => Author::getAll(), 'book_authors' => $found_book->getAuthors()));
    });

    $app->post("/search_by_author", function() use ($app) {
        $book_author_name = $_POST['book_author_name'];
        $found_author = Author::findAuthorByName($book_author_name);
        $found_books = $found_author->getBooks();
        return $app['twig']->render('edit_author.html.twig', array('author' => $found_author, 'all_books' => Book::getAll(), 'author_books' => $found_books));
    });

    $app->post("/add_book", function() use ($app) {
        $title = $_POST['title'];
        $new_book = new Book($title);
        $new_book->save();
        return $app['twig']->render('librarian.html.twig', array('all_books' => Book::getAll()));
    });

    $app->get("/edit_book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('edit_book.html.twig', array('book' => $book, 'all_authors' => Author::getAll(), 'book_authors' => $book->getAuthors()));
    });

    $app->patch("/edit_book/{id}", function($id) use ($app) {
        $title  = $_POST['title'];
        $book = Book::find($id);
        $book->updateTitle($title);
        return $app['twig']->render('edit_book.html.twig', array('book' => $book));
    });

    $app->post("/assign_author/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $author = Author::find($_POST['all_authors']);
        $book->addAuthor($author);
        return $app['twig']->render('edit_book.html.twig', array('book' => $book, 'all_authors' => Author::getAll(), 'book_authors' => $book->getAuthors()));
    });

    $app->delete("/delete_book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app['twig']->render('librarian.html.twig', array('all_books' => Book::getAll()));
    });

    $app->post("/add_author", function() use ($app) {
        $author_name = $_POST['author_name'];
        $new_author = new Author($author_name);
        $new_author->save();
        return $app['twig']->render('librarian.html.twig', array('all_books' => Book::getAll(), 'all_authors' => Author::getAll()));
    });

    $app->get("/edit_author/{id}", function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('edit_author.html.twig', array('author' => $author, 'all_books' => Book::getAll(), 'author_books' => $author->getBooks()));
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
        return $app['twig']->render('librarian.html.twig', array('all_books' => Book::getAll(), 'all_authors' => Author::getAll()));
    });

    $app->post("/assign_book/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $book = Book::find($_POST['all_books']);
        $author->addBook($book);
        return $app['twig']->render('edit_author.html.twig', array('author' => $author, 'all_books' => Book::getAll(), 'author_books' => $author->getBooks()));
    });

    return $app;
?>
