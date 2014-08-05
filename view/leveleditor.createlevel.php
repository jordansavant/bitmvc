<h1>Create Level</h1>

<?php echo $args['error'] ? $args['error'] ."<br>" : ""; ?>

<form action="index.php?c=<?=$C?>&o=createlevel" method="post">
<?php echo $args['rzLevel']->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
