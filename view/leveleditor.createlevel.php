<h1>Create Level</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>

<form action="index.php?c=<?=$C?>&o=createlevel&lp=<?=$this->rzLevelPack->name?>" method="post">
<?php echo $this->rzLevel->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
