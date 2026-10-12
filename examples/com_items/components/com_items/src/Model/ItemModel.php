<?php

namespace Dev\Component\Items\Site\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ItemModel as BaseItemModel;

class ItemModel extends BaseItemModel
{
	public function getItem($pk = null)
	{
		$id    = Factory::getApplication()->getInput()->get('id', 0, 'INT');
		$table = $this->getTable('Item', 'Administrator');

		if (!$table->load($id) || (int) $table->state !== 1) {
			throw new \UnexpectedValueException('Item not found');
		}

		return $table;
	}
}
