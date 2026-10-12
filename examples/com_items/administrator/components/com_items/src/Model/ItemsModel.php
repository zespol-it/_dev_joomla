<?php

namespace Dev\Component\Items\Administrator\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class ItemsModel extends ListModel
{
	protected function getListQuery()
	{
		$db    = $this->getDatabase();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(['id', 'title', 'state']))
			->from($db->quoteName('#__items'))
			->order($db->quoteName('id') . ' ASC');

		return $query;
	}
}
