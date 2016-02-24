<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Pet.php";
    require_once __DIR__."/../src/Breed.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=animal_shelter';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig', array('breeds' => Breed::getAll()));
    });

    $app->get("/pets", function() use ($app) {
        return $app['twig']->render('pets.html.twig', array('pets' => Pet::getAll()));
    });

    $app->get("/breeds", function() use ($app) {
    return $app['twig']->render('breeds.html.twig', array('breeds' => Breed::getAll()));
    });

    $app->get("/breeds/{id}", function($id) use ($app) {
    $breed = Breed::find($id);
    return $app['twig']->render('breed.html.twig', array('breed' => $breed, 'pets' => $breed->getPets()));
    });

    $app->post("/breeds", function() use ($app) {
        $breed = new Breed($_POST['name']);
        $breed->save();
        return $app['twig']->render('index.html.twig', array('breeds' => Breed::getAll()));
    });

    $app->post("/pets", function() use ($app) {
        $description = $_POST['description'];
        $breed_id = $_POST['breed_id'];
        $task = new Pet($description, $id = null, $breed_id);
        $task->save();
        $breed = Breed::find($breed_id);
        return $app['twig']->render('breed.html.twig', array('breed' => $breed, 'pets' => $breed->getPets()));
    });

    $app->post("/delete_pets", function() use ($app) {
        Pet::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_breeds", function() use ($app) {
       Breed::deleteAll();
       return $app['twig']->render('index.html.twig');
   });

    return $app;

?>
