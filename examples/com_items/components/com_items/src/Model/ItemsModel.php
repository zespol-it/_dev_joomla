<?php

namespace Dev\Component\Items\Site\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;

class ItemsModel extends ListModel
{
	protected function getListQuery()
	{
		$db    = $this->getDatabase();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(['id', 'title', 'description']))
			->from($db->quoteName('#__items'))
			->where($db->quoteName('state') . ' = 1')
			->order($db->quoteName('id') . ' ASC');

		return $query;
	}
}
