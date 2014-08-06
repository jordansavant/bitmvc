<h1>Create Level Pack</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>

<form action="index.php?c=<?=$C?>&o=createlevelpack" method="post">
<?php echo $this->rzLevelPack->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
