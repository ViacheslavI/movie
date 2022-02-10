<?php

namespace app\Controllers;

use app\Models\Main;
use app\libs\Pagination;
use app\core\Registry;
use app\core\base\View;

class MainController extends BaseController
{
    public $posterId = '';

    public function indexAction()
    {
        if (empty($_SESSION['email'])) {
            redirect('user/login');
        }
        $model = Registry::instance();
        $total = $model->main->getRecordsInTable();
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 2;
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();
        $movies = $model->main->getAllMovie($perpage, $start);
        View::setMeta('Main page', 'description page', 'site keywords');
        $this->set(compact('movies', 'pagination', 'total'));
    }

    public function aboutAction()
    {
        $movieId = h($_POST['movieId']);
        $model = Registry::instance();
        $movie = $model->main->aboutMovie($movieId);
        $this->set(compact('movie'));
    }

    public function storeAction()
    {
        if (!empty($_POST) && !empty($_FILES)) {
            $main = new Main();
            $data = $_POST;
            $dataFile = $_FILES['poster_image'];
            $main->load($data);
            if (!$main->validate($data) || !$main->canUpload($dataFile)) {
                $main->getErrors();
                $_SESSION['form_data_store'] = $data;
                redirect('/main/store');
            } else {
                $main->makeUpload($dataFile, $data);
                redirect('/');
            }
        }
    }

    public function editAction()
    {
        if (!empty($_POST) || !empty($_FILES)) {
            $main = new Main();
            $_POST['title'] = h($_POST['title']);
            $_POST['date'] = h($_POST['date']);
            $_POST['conten'] = h($_POST['conten']);
            $data = $_POST;
            $mId = h($_POST['movieId']);
            if (empty($_FILES)) {
                $posterId = $main->getLinkPoster($mId);
                $this->posterId = $posterId[0]['url_poster'];
            }
            $main->load($data);
            if (!$main->validate($data)) {
                $main->getErrors();
                $_SESSION['form_data_store'] = $data;
                redirect('/main/edit');
            } else {
                $uId = $main->getUserId();
                $main->editMovie($this->posterId, $data, $mId, $uId);
                //redirect('/');
            }
        }
    }

    public function deleteAction()
    {
        $model = Registry::instance();
        $mId = h($_POST['movieId']);
        $model->main->softDelete($mId);
        redirect('');
    }
}
