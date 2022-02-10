<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="text-right p-3">
    <a href="/main/store"><i class="btn btn-success">Add Movie</i></a>
</div>
<div class="container mt-3">
    <table class="table">
        <thead>
        <tr>
            <th>name</th>
            <th>Description</th>
            <th>ReleaseDate</th>
            <th>Image</th>
            <th colspan="3" class="text-center">Setting</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($movies as $movie) : ?>
            <tr>
                <td><?= $movie['name'] ?></td>
                <td class="text-align justify"><?= $movie['description'] ?></td>
                <td><?= $movie['releaseDate'] ?></td>
                <td><img class=" w-75 " src="<?= $movie['url_poster'] ?>"/></td>
                <td>
                    <form action="/main/about" method="post">
                        <button name="movieId" class="btn btn-secondary" type="submit"
                                value="<?= $movie['movieId'] ?>"/>
                        About
                    </form>
                </td>
                <td>
                    <form action="/main/edit" method="post">
                        <button name="movieId" class="btn btn-primary" type="submit" value="<?= $movie['movieId'] ?>"/>
                        Edit
                    </form>
                </td>
                <td>
                    <form action="/main/delete" method="post">
                        <button name="movieId" class="btn btn-danger" type="submit" value="<?= $movie['movieId'] ?>"/>
                        Delete
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="text-justify">
        <?php if ($pagination->countPages > 1) : ?>
            <?= $pagination; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
