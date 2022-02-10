<?php

namespace app\Models;

use app\core\base\Model;

class Main extends Model
{
    public $table = 'movie';
    public $attributes = [
        'title' => '',
        'date' => '',
        'conten' => '',
    ];
    public $errors = [];
    public $rules = [
        'required' => [
            ['title'],
            ['date'],
            ['conten'],
        ],
        'lengthMin' => [
            ['title', 25],
            ['conten', 255],
        ],
    ];

    public function canUpload($file)
    {
        if ($file['name'] == '') {
            $_SESSION['file']['name'] = 'Вы не выбрали файл';
            return false;
        }
        if ($file['size'] == 0) {
            $_SESSION['file']['size'] = 'Файл слишком большой';
            return false;
        }
        $getMime = explode('.', $file['name']);
        $mime = strtolower(end($getMime));
        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
        if (!in_array($mime, $types)) {
            $_SESSION['file']['type'] = 'Недопустимый тип файла';
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors [] = $item;
            }
        }
        $_SESSION['errorStore'] = $errors;
    }

    public function makeUpload($file, $dataCont)
    {
        //путь для бд где лежит картинка
        $path = "http://localhost/public/images/";
        //путь кда сохранить картинку
        $save_path = "C://xampp/htdocs/test_viacheslav_ivanskiy/public/images/";
        $name = mt_rand(0, 10000) . $file['poster_image']['name'];
        copy($_FILES['poster_image']['tmp_name'], $save_path . $name);
        $data['file_name'] = $path . $name;
        return $this->uploadImage($data['file_name'], $dataCont);
    }

    public function uploadImage($data, $dataCont)
    {
        $title = $dataCont['title'];
        $content = $dataCont['conten'];
        $date = $dataCont['date'];
        $userId = $this->getUserId();
        $userId = $userId[0]['id'];
        $sql = "INSERT INTO {$this->table}(`url_poster`, `user_id`,`name`,`description`,`releaseDate`) VALUES (:data,:userId,:title, :content,:date)";
        $params = [
            ':data' => $data,
            ':userId' => $userId,
            ':title' => $title,
            ':content' => $content,
            ':date' => $date
        ];
        return $this->pdo->query($sql, $params);
    }

    public function getLinkPoster($data)
    {
        $que = "SELECT `url_poster`FROM {$this->table} WHERE `movieId` = :data";
        $param = [':data' => $data];
        return $this->pdo->query($que, $param);
    }

    public function editMovie($posterId, $data, $mId, $uId)
    {
        $que = "UPDATE {$this->table} SET `name` = :title, `description`=:conten,`releaseDate`=:date,`url_poster`=:posterId, `user_id`=:userId  WHERE `movieId` = :mId";
        $params = [
            ':title' => $data['title'],
            ':conten' => $data['conten'],
            ':date' => $data['date'],
            ':posterId' => $posterId,
            ':userId' => $uId,
            ':mId' => $mId,
        ];
        return $this->pdo->query($que, $params);
    }

    public function softDelete($Id)
    {
        $sql = "UPDATE {$this->table} SET `deleted_at` = 0  WHERE `movieId` = :Id";
        $param = [':Id' => $Id];
        return $this->pdo->query($sql, $param);
    }

    public function getUserId()
    {
        $email = $_SESSION['email'];
        $que = "SELECT {$this->pk} from `users` where email = :email";
        $param = [':email' => $email];
        return $this->pdo->query($que, $param);
    }

    public function aboutMovie($data)
    {
        $que = "SELECT * FROM {$this->table} WHERE `movieId` = :data";
        $param = [':data' => $data];
        return $this->pdo->query($que, $param);
    }

    public function getAllMovie($perpage, $start)
    {
        $sql = "SELECT * FROM {$this->table} WHERE `deleted_at` = 1 LIMIT {$start},{$perpage}";
        return $this->pdo->query($sql);
    }
}
