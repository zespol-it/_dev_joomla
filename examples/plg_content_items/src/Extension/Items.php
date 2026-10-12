<?php

namespace Dev\Plugin\Content\Items\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Event\Content\ContentPrepareEvent;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseInterface;
use Joomla\Event\SubscriberInterface;

class Items extends CMSPlugin implements SubscriberInterface
{
	protected $autoloadLanguage = true;

	public static function getSubscribedEvents(): array
	{
		return [
			'onContentPrepare' => 'onContentPrepare',
		];
	}

	public function onContentPrepare(ContentPrepareEvent $event): void
	{
		$app = $this->getApplication();

		if (!$app->isClient('site')) {
			return;
		}

		if (!(int) $this->params->get('show_count', 1)) {
			return;
		}

		$context = $event->getContext();

		if ($context !== 'com_content.article' && $context !== 'com_content.featured') {
			return;
		}

		$count   = $this->countPublishedItems();
		$article = $event->getItem();
		$footer  = '<p class="plg-content-items">'
			. htmlspecialchars(Text::sprintf('PLG_CONTENT_ITEMS_FOOTER', $count), ENT_QUOTES, 'UTF-8')
			. '</p>';

		$article->text .= $footer;
	}

	private function countPublishedItems(): int
	{
		try {
			/** @var DatabaseInterface $db */
			$db = Factory::getContainer()->get(DatabaseInterface::class);
			$query = $db->getQuery(true)
				->select('COUNT(*)')
				->from($db->quoteName('#__items'))
				->where($db->quoteName('state') . ' = 1');
			$db->setQuery($query);

			return (int) $db->loadResult();
		} catch (\Throwable $e) {
			return 0;
		}
	}
}
