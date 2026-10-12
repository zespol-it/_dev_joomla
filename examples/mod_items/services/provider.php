<?php

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\HelperFactory as HelperFactoryServiceProvider;
use Joomla\CMS\Extension\Service\Provider\Module as ModuleServiceProvider;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory as ModuleDispatcherFactoryServiceProvider;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
	public function register(Container $container): void
	{
		$container->registerServiceProvider(new ModuleDispatcherFactoryServiceProvider('\\Dev\\Module\\Items'));
		$container->registerServiceProvider(new HelperFactoryServiceProvider('\\Dev\\Module\\Items\\Site\\Helper'));
		$container->registerServiceProvider(new ModuleServiceProvider());
	}
};
