<?php

namespace Dev\Module\Items\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;

class ItemsHelper
{
	public static function getItems(int $count = 5): array
	{
		/** @var DatabaseInterface $db */
		$db    = Factory::getContainer()->get(DatabaseInterface::class);
		$query = $db->getQuery(true)
			->select($db->quoteName(['id', 'title']))
			->from($db->quoteName('#__items'))
			->where($db->quoteName('state') . ' = 1')
			->order($db->quoteName('id') . ' DESC')
			->setLimit($count);

		$db->setQuery($query);

		return $db->loadObjectList() ?: [];
	}
}
