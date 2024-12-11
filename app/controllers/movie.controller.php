<?php

require_once './app/models/movie.model.php';
require_once './app/models/review.model.php';
require_once './app/views/movie.view.php';

class MovieController
{
    private $movieModel;
    private $movieView;
    private $reviewModel;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
        $this->movieView = new MovieView();
        $this->reviewModel = new ReviewModel();
    }

    public function showMovies()
    {
        $movies = $this->movieModel->getMovies();
        $this->movieView->showMovies($movies);
    }

    public function showMovie($id)
    {
        $movie = $this->movieModel->getMovie($id);
        $reviews = $this->reviewModel->getMovieReviews($id);
        $this->movieView->showMovie($movie, $reviews);
    }

    public function addMovie()
    {
        AuthHelper::verify();

        if (
            isset($_POST['title']) && ($_POST['title'] != null)
            && isset($_POST['director']) && ($_POST['director'] != null)
            && isset($_POST['synopsis']) && ($_POST['synopsis'] != null)
            && isset($_POST['release_date']) && ($_POST['release_date'] != null)
            && isset($_POST['runtime']) && ($_POST['runtime'] != null)
            && isset($_POST['genre']) && ($_POST['genre'] != null)
        ) {

            $title = $_POST['title'];
            $director = $_POST['director'];
            $synopsis = $_POST['synopsis'];
            $release_date = $_POST['release_date'];
            $runtime = $_POST['runtime'];
            $genre = $_POST['genre'];

            $this->movieModel->addMovie($title, $director, $synopsis, $release_date, $runtime, $genre);
            header('Location: ' . BASE_URL . 'movies');
        } else {
            $this->movieView->error("Complete todos los campos para agregar");
        }
    }
    public function editMovieForm($id)
    {
        AuthHelper::verify();

        $movie = $this->movieModel->getMovie($id);
        $movies = $this->movieModel->getMovies();
        $this->movieView->editMovieForm($movie, $movies);
    }

    public function editMovie($id)
    {
        AuthHelper::verify();
        if (
            isset($_POST['title']) && ($_POST['title'] != null)
            && isset($_POST['director']) && ($_POST['director'] != null)
            && isset($_POST['synopsis']) && ($_POST['synopsis'] != null)
            && isset($_POST['release_date']) && ($_POST['release_date'] != null)
            && isset($_POST['runtime']) && ($_POST['runtime'] != null)
            && isset($_POST['genre']) && ($_POST['genre'] != null)
        ) {

            $title = $_POST['title'];
            $director = $_POST['director'];
            $synopsis = $_POST['synopsis'];
            $release_date = $_POST['release_date'];
            $runtime = $_POST['runtime'];
            $genre = $_POST['genre'];

            $this->movieModel->editMovie($title, $director, $synopsis, $release_date, $runtime, $genre, $id);
            header('Location: ' . BASE_URL . 'movies');
        } else {
            $this->movieView->error("Complete todos los campos para actualizar");
        }
    }
    public function removeMovie($id)
    {
        AuthHelper::verify();
        $movie = $this->movieModel->getMovie($id);
        if (!$movie) {
            $this->movieView->error("La película que se quiere eliminar no existe");
        } else {
            $this->movieModel->deleteMovie($id);
            header('Location: ' . BASE_URL . 'movies');
        }
    }
}
