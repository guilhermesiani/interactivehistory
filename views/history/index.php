<header class="main">
	<a href="<?php echo URL; ?>" id="home-button">Início</a>
	<a href="<?= URL; ?>history/<?= $this->history->getSlug(); ?>/<?= ($this->history->getVerticalPosition() + 1) ?>" id="title"><h1><?php echo $this->history->getTitle(); ?></h1></a>
</header>
<div class="center">
	<article id="history">
		<p><?php echo $this->history->getContent(); ?></p>
		<form method="POST" action="<?= URL; ?>history/<?= $this->history->getSlug(); ?>/<?= ($this->history->getVerticalPosition() + 2) ?>">
			<?php if ($this->history->pageHasOptions($this->history->getVerticalPosition(), $this->history->getHorizontalPosition())): ?>
				<div class="history-options">
					<span>
						<input type="radio" name="nextHorizontalPosition" value="<?= $this->history->getPageOption($this->history->getVerticalPosition(), $this->history->getHorizontalPosition(), 0)['nextHorizontalPosition'] ?>"> 
						<?= $this->history->getPageOption($this->history->getVerticalPosition(), $this->history->getHorizontalPosition(), 0)['optionText'] ?>
					</span>
					<span>
						<input type="radio" name="nextHorizontalPosition" value="<?= $this->history->getPageOption($this->history->getVerticalPosition(), $this->history->getHorizontalPosition(), 1)['nextHorizontalPosition'] ?>"> 
						<?= $this->history->getPageOption($this->history->getVerticalPosition(), $this->history->getHorizontalPosition(), 1)['optionText'] ?>
					</span>
				</div>
			<?php endif; ?>
			<?php if ($this->history->getVerticalPosition() != $this->history->getPages()): ?>
				<input type="hidden" name="nextPage" value="1">
				<button id="next-page">Avançar »</button>
			<?php endif; ?>
		</form>
	</article>
	<aside>
		<nav id="navpage">
			<h3>Páginas</h3>
			<ul>
				<?php for ($i = 0; $i < $this->history->getPages(); $i++): ?>
					<?php if ($i < $this->history->getVerticalPosition()): ?>
						<li><a href="<?= URL; ?>history/<?= $this->history->getSlug(); ?>/<?= ($i+1) ?>"><s>Página <?php echo ($i+1); ?></s></a></li>
					<?php else: ?>
						<li><a href="<?= URL; ?>history/<?= $this->history->getSlug(); ?>/<?= ($i+1) ?>">Página <?php echo ($i+1); ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>
				<li><a href="<?= URL; ?>history/<?= $this->history->getSlug(); ?>/1">Créditos</a></li>
			</ul>
		</nav>
	</aside>	
</div>