<?php

namespace Dev\Component\Items\Site\View\Items;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items = $this->getModel()->getItems();
		$this->getDocument()->setTitle('Items');

		return parent::display($tpl);
	}
}
