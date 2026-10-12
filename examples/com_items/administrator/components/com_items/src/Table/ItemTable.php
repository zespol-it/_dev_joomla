<?php

namespace Dev\Component\Items\Administrator\Table;

\defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseInterface;

class ItemTable extends Table
{
	public function __construct(DatabaseInterface $db)
	{
		parent::__construct('#__items', 'id', $db);
	}
}
