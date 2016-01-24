<header class="main">
	<a href="" id="title"><h1>Contos de Horror</h1></a>
</header>
<section class="main center">
	<?php foreach($this->histories as $history) { ?>
		<article>
			<a href="<?= URL; ?>history/<?php echo $history['slug']; ?>"><h2><?php echo $history['title']; ?></h2></a>
			<p><?php echo substr($history['content'], 0, 161); ?> <a class="continue-reading" href="<?= URL; ?>history/<?php echo $history['slug']; ?>">continuar lendo</a></p>
		</article>
	<?php } ?>	
</section>