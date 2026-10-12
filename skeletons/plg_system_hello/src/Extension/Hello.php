<?php

namespace Dev\Plugin\System\Hello\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

class Hello extends CMSPlugin implements SubscriberInterface
{
	protected $autoloadLanguage = true;

	public static function getSubscribedEvents(): array
	{
		return [
			'onAfterRender' => 'onAfterRender',
		];
	}

	public function onAfterRender(Event $event): void
	{
		if (!$this->getApplication()->isClient('site')) {
			return;
		}

		if (!(int) $this->params->get('enabled_message', 0)) {
			return;
		}

		// Skeleton hook: intentionally no-op unless you enable the parameter and extend this method.
	}
}
