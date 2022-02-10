<div>
    <?php foreach ($movie as $value):?>
    <img src="<?=$value['url_poster']?>" class="w-25 ml-5 mt-2" alt="image">
    <?php endforeach;?>
    <h2 class="ml-5"><?=$value['name']?></h2>
    <h8 class="ml-5">Release Date: <?=$value['releaseDate']?></h8>
    <div class="p-4"><?=$value['description']?></div>
</div>