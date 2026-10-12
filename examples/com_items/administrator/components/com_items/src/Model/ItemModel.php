<?php

namespace Dev\Component\Items\Administrator\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormFactoryAwareInterface;
use Joomla\CMS\Form\FormFactoryAwareTrait;
use Joomla\CMS\MVC\Model\FormBehaviorTrait;
use Joomla\CMS\MVC\Model\FormModelInterface;
use Joomla\CMS\MVC\Model\ItemModel as BaseItemModel;

class ItemModel extends BaseItemModel implements FormFactoryAwareInterface, FormModelInterface
{
	use FormFactoryAwareTrait;
	use FormBehaviorTrait;

	public function getForm($data = [], $loadData = true)
	{
		$form = $this->loadForm(
			'com_items.item',
			'item',
			[
				'control'   => 'jform',
				'load_data' => $loadData,
			]
		);

		if (empty($form)) {
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = Factory::getApplication()->getUserState('com_items.edit.item.data', []);

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	public function getItem($pk = null)
	{
		$app   = Factory::getApplication();
		$id    = $app->getInput()->get('id', 0, 'INT');
		$table = $this->getTable('Item', 'Administrator');

		if ($id === 0) {
			$table->id          = 0;
			$table->title       = '';
			$table->description = '';
			$table->state       = 1;

			return $table;
		}

		if (!$table->load($id)) {
			throw new \UnexpectedValueException('Item id out of range');
		}

		return $table;
	}

	public function filter($form, $data)
	{
		return $form->filter($data);
	}

	public function validate($form, $data, $group = null)
	{
		$result = $form->validate($data, $group);

		if ($result instanceof \Exception) {
			$this->setError($result->getMessage());

			return false;
		}

		if ($result === false) {
			foreach ($form->getErrors() as $message) {
				$this->setError($message);
			}

			return false;
		}

		return true;
	}

	public function save($data)
	{
		$table = $this->getTable();
		$id    = (int) ($data['id'] ?? 0);

		if ($id > 0 && !$table->load($id)) {
			throw new \UnexpectedValueException('Item id out of range');
		}

		if (!$table->bind($data)) {
			$this->setError($table->getError());

			return false;
		}

		if (!$table->check()) {
			$this->setError($table->getError());

			return false;
		}

		if (!$table->store()) {
			$this->setError($table->getError());

			return false;
		}

		return true;
	}
}
