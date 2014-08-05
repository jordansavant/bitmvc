<h1>Create Level Pack</h1>

<?php echo $args['error'] ? $args['error'] ."<br>" : ""; ?>

<form action="index.php?c=<?=$C?>&o=createlevelpack" method="post">
<?php echo $args['rzLevelPack']->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
