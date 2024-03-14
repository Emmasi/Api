<?php


$movies = [
    ["id" => 1, "title" => "Movie1", "category" => "Comedy"],
    ["id" => 2, "title" => "Movie2", "category" => "Animated"],
    ["id" => 3, "title" => "Movie3", "category" => "Thriller"]
];

$app = new Flask(__name__);

// get all movies
$app->route('/movies', 'GET', function () use ($movies) {
    return json_encode($movies);
});

// get movie by id
$app->route('/movies/<int:movie_id>', 'GET', function ($movie_id) use ($movies) {
    foreach ($movies as $movie) {
        if ($movie['id'] == $movie_id) {
            return json_encode($movie);
        }
    }
    return json_encode(["Error" => "Cannot find any movie"]), 404;
});

// add movie
$app->route('/movies', 'POST', function () use ($movies) {
    $new_movie = [
        "id" => count($movies) + 1,
        "title" => $_POST['title'],
        "category" => $_POST['category']
    ];
    array_push($movies, $new_movie);
    return json_encode($new_movie);
});

// update movie 
$app->route('/movies/<int:movie_id>', 'PUT', function ($movie_id) use ($movies) {
    foreach ($movies as &$movie) {
        if ($movie['id'] == $movie_id) {
            $movie['title'] = $_POST['title'];
            $movie['category'] = $_POST['category'];
            return json_encode($movie);
        }
    }
    return json_encode(["Error" => "Cannot find any movie"]), 404;
});

// delete movie
$app->route('/movies/<int:movie_id>', 'DELETE', function ($movie_id) use ($movies) {
    foreach ($movies as $key => $movie) {
        if ($movie['id'] == $movie_id) {
            unset($movies[$key]);
            return;
        }
    }
    return json_encode(["Error" => "Cannot find any movie"]), 404;
});

// start
$app->run(debug=True);

?>
