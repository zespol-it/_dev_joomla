<?php

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<div class="mod-items">
	<?php if (empty($items)) : ?>
		<p><?php echo Text::_('MOD_ITEMS_NO_ITEMS'); ?></p>
	<?php else : ?>
		<ul>
			<?php foreach ($items as $item) : ?>
				<li>
					<a href="<?php echo Route::_('index.php?option=com_items&view=item&id=' . (int) $item->id); ?>">
						<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
