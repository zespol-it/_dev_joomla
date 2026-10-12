<?php

namespace Dev\Component\Items\Site\View\Item;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView
{
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->getModel()->getItem();
		$this->getDocument()->setTitle($this->item->title);

		return parent::display($tpl);
	}
}
