<h1>Index</h1>
<ul>
<?php
foreach($args['files'] as $file)
{
?>
    <li><?=$file?> - <a href="index.php?c=<?=$C?>&o=editlevelpack&name=<?=$file?>">edit</a></li>
<?php
}
?>
</ul>
<a href="index.php?c=leveleditor&o=createLevelpack">Create Levelpack</a>
