<?php

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<table class="table">
	<caption class="visually-hidden"><?php echo Text::_('COM_ITEMS_ITEMS_CAPTION'); ?></caption>
	<thead>
		<tr>
			<th scope="col"><?php echo Text::_('COM_ITEMS_ITEM_TITLE_LABEL'); ?></th>
			<th scope="col"><?php echo Text::_('JSTATUS'); ?></th>
			<th scope="col"><?php echo Text::_('JGRID_HEADING_ID'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->items as $item) : ?>
			<tr>
				<th scope="row">
					<a href="<?php echo Route::_('index.php?option=com_items&task=item.edit&id=' . (int) $item->id); ?>">
						<?php echo $this->escape($item->title); ?>
					</a>
				</th>
				<td><?php echo ((int) $item->state === 1) ? Text::_('JPUBLISHED') : Text::_('JUNPUBLISHED'); ?></td>
				<td><?php echo (int) $item->id; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
