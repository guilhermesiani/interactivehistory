<header class="main">
	<a href="<?php echo URL; ?>" id="home-button">Início</a>
	<a href="" id="title"><h1><?php echo $this->history->getTitle(); ?></h1></a>
</header>
<div class="center">
	<article id="history">
		<p><?php echo $this->history->getContent(); ?></p>
		<?php if ($this->history->pageHasOptions($this->history->getVerticalPosition())): ?>
			<div class="history-options">
				<span><input type="radio" name="option" value="0"> Lorem ipsum dolor sit amet</span>
				<span><input type="radio" name="option" value="1"> Nam a sollicitudin lacus</span>
			</div>
		<?php endif; ?>
		<button id="next-page" href="#">Avançar »</button>
	</article>
	<aside>
		<nav id="navpage">
			<h3>Páginas</h3>
			<ul>
				<?php for ($i = 0; $i < $this->history->getPages(); $i++): ?>
					<?php if ($i <= $this->history->getVerticalPosition()): ?>
						<li><a href="#"><s>Página <?php echo ($i+1); ?></s></a></li>
					<?php else: ?>
						<li><a href="#">Página <?php echo ($i+1); ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>
				<li><a href="#">Fim</a></li>
			</ul>
		</nav>
	</aside>	
</div>