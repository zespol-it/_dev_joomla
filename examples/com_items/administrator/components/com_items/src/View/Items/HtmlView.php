<?php

namespace Dev\Component\Items\Administrator\View\Items;

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class HtmlView extends BaseHtmlView
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items = $this->getModel()->getItems();
		ToolbarHelper::title(Text::_('COM_ITEMS_MANAGER_ITEMS'), 'list');
		ToolbarHelper::addNew('item.add');

		return parent::display($tpl);
	}
}
