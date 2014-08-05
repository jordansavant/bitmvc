<h1>Edit Level Pack: <?= $args['rzLevelPack']->name ?></h1>
<ul>
<?php
foreach($args['rzLevelPack']->rzLevels as $rzLevel)
{
?>
    <li><?=$level?> - <a href="index.php?c=<?=$C?>&o=editlevel&levelpackname=<?=$level?>&levelid=<?=$level->id?>">edit</a></li>
<?php
}
?>
</ul>
<a href="index.php?c=<?=$C?>&o=createLevel&levelpackname=<?=$args['rzLevelPack']->name?>">Create Level</a>
