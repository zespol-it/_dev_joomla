<?php

namespace Dev\Module\Items\Site\Dispatcher;

\defined('_JEXEC') or die;

use Dev\Module\Items\Site\Helper\ItemsHelper;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Input\Input;
use Joomla\Registry\Registry;

class Dispatcher implements DispatcherInterface
{
	protected $module;
	protected $app;

	public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)
	{
		$this->module = $module;
		$this->app    = $app;
	}

	public function dispatch()
	{
		$language = $this->app->getLanguage();
		$language->load('mod_items', JPATH_BASE . '/modules/mod_items');

		$params = new Registry($this->module->params);
		$count  = (int) $params->get('count', 5);
		$items  = ItemsHelper::getItems($count);

		require ModuleHelper::getLayoutPath('mod_items');
	}
}
