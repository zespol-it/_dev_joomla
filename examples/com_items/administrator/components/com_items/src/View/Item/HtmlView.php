<?php

namespace Dev\Component\Items\Administrator\View\Item;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class HtmlView extends BaseHtmlView
{
	protected $form;
	protected $item;

	public function display($tpl = null)
	{
		$model      = $this->getModel();
		$this->form = $model->getForm();
		$this->item = $model->getItem();

		Factory::getApplication()->getInput()->set('hidemainmenu', true);
		ToolbarHelper::title(Text::_('COM_ITEMS_MANAGER_ITEM_EDIT'), 'pencil-alt');
		ToolbarHelper::apply('item.apply');
		ToolbarHelper::save('item.save');
		ToolbarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');

		return parent::display($tpl);
	}
}
