<?php

require_once './app/models/review.model.php';
require_once './app/views/review.view.php';

class reviewController
{
    private $reviewModel;
    private $movieModel;
    private $reviewView;


    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->movieModel = new MovieModel();
        $this->reviewView = new ReviewView();
    }

    public function showReviews()
    {
        $reviews = $this->reviewModel->getReviews();
        $movies = $this->movieModel->getMovies();
        $this->reviewView->showReviews($reviews, $movies);
    }

    public function showReview($id)
    {
        $review = $this->reviewModel->getReview($id);
        $this->reviewView->showReview($review);
    }

    public function addReview()
    {
        AuthHelper::verify();

        if (
            isset($_POST['id_movie']) && ($_POST['id_movie'] != null)
            && isset($_POST['body']) && ($_POST['body'] != null)
            && isset($_POST['rating']) && ($_POST['rating'] != null)
        ) {
            $id_movie = $_POST['id_movie'];
            $body = $_POST['body'];
            $rating = $_POST['rating'];

            $this->reviewModel->addReview($id_movie, $body, $rating);
            header('Location: ' . BASE_URL . 'reviews');
        } else {
            $this->reviewView->error("Complete todos los campos para actualizar");
        }
    }
    public function editReviewForm($id)
    {
        AuthHelper::verify();

        $review = $this->reviewModel->getReview($id);
        $reviews = $this->reviewModel->getReviews();
        $movies = $this->movieModel->getMovies();
        $this->reviewView->editReviewForm($review, $reviews, $movies);
    }

    public function editReview($id)
    {
        AuthHelper::verify();

        if (
            isset($_POST['id_movie']) && ($_POST['id_movie'] != null)
            && isset($_POST['body']) && ($_POST['body'] != null)
            && isset($_POST['rating']) && ($_POST['rating'] != null)
        ) {
            $id_movie = $_POST['id_movie'];
            $body = $_POST['body'];
            $rating = $_POST['rating'];

            $this->reviewModel->editReview($id_movie, $body, $rating, $id);
            header('Location: ' . BASE_URL . 'reviews');
        } else {
            $this->reviewView->error("Complete todos los campos para actualizar");
        }
    }
    public function removeReview($id)
    {
        AuthHelper::verify();
        $review=$this->reviewModel->getReview($id);
        if(!$review){
            $this->reviewView->error("La reseña que se quiere eliminar no existe");
        }else{
            $this->reviewModel->deleteReview($id);
        header('Location: ' . BASE_URL . 'reviews');
        }
        
    }
}
