##start-breadcrumb##
 &gt; <a href="index.php?c=<?=$C?>&o=editLevelPack&lp=<?=$this->lp?>">Level Pack</a>
 &gt; <a href="index.php?c=<?=$C?>&o=editLevel&lp=<?=$this->lp?>&lid=<?=$this->lid?>">Level</a>
##end##

<h1>Create Light</h1>

<?php echo $this->error ? $this->error ."<br>" : ""; ?>
<form action="index.php?c=<?=$C?>&o=createLight&lp=<?=$this->rzLevelPack->name?>&lid=<?=$this->rzLevel->id?>&index=<?=$this->index?>" method="post">
<?php echo $this->rzLight->toForm(); ?>
<br>
<input type="submit" value="Create" />
</form>
