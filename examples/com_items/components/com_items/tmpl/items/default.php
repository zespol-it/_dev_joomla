<?php

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<div class="com-items-items">
	<h1><?php echo Text::_('COM_ITEMS_ITEMS_HEADING'); ?></h1>
	<ul>
		<?php foreach ($this->items as $item) : ?>
			<li>
				<a href="<?php echo Route::_('index.php?option=com_items&view=item&id=' . (int) $item->id); ?>">
					<?php echo $this->escape($item->title); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
