<header class="main">
	<a href="" id="title"><h1>Contos de Horror</h1></a>
</header>
<section class="main center">
	<?php foreach($this->histories as $history) { ?>
		<article>
			<a href="<?php echo URL; ?>history/<?php echo $history['slug']; ?>"><h2><?php echo $history['title']; ?></h2></a>
			<p><?php echo substr($history['content'], 0, 161); ?> <a class="continue-reading" href="<?php echo URL; ?>history">continuar lendo</a></p>
		</article>
	<?php } ?>
	<article>
		<a href="<?php echo URL; ?>history"><h2>Bárbara, a adolescente possuída</h2></a>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a sollicitudin lacus. Suspendisse potenti. Nulla nec enim pulvinar, varius risus eu, aliquam tortor. <a class="continue-reading" href="<?php echo URL; ?>history">continuar lendo</a></p>
	</article>
	<article>
		<a href="<?php echo URL; ?>history"><h2>O assassino que nunca cessou</h2></a>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a sollicitudin lacus. Suspendisse potenti. Nulla nec enim pulvinar, varius risus eu, aliquam tortor. <a class="continue-reading" href="<?php echo URL; ?>history">continuar lendo</a></p>
	</article>
	<article>
		<a href="<?php echo URL; ?>history"><h2>O covil de Martin Waine</h2></a>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a sollicitudin lacus. Suspendisse potenti. Nulla nec enim pulvinar, varius risus eu, aliquam tortor. <a class="continue-reading" href="<?php echo URL; ?>history">continuar lendo</a></p>
	</article>		
</section>