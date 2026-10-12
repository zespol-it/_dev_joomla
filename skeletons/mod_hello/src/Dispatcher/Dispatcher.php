<?php

namespace Dev\Module\Hello\Site\Dispatcher;

\defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
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
		$language->load('mod_hello', JPATH_BASE . '/modules/mod_hello');

		$params   = new Registry($this->module->params);
		$greeting = $params->get('greeting', 'Hello');
		$hello    = Text::sprintf('MOD_HELLO_MESSAGE', $greeting);

		require ModuleHelper::getLayoutPath('mod_hello');
	}
}
