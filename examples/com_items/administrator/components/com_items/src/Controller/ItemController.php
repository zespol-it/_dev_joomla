<?php

namespace Dev\Component\Items\Administrator\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;

class ItemController extends BaseController
{
	public function edit()
	{
		$id = $this->input->get('id', 0, 'INT');
		$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=' . $id, false));

		return true;
	}

	public function cancel()
	{
		$this->checkToken();
		$this->app->setUserState('com_items.edit.item.data', null);
		$this->setRedirect(Route::_('index.php?option=com_items&view=items', false));

		return true;
	}

	public function save($key = null, $urlVar = null)
	{
		$this->checkToken();

		$model = $this->getModel();
		$data  = $this->input->post->get('jform', [], 'array');
		$id    = (int) ($data['id'] ?? 0);
		$form  = $model->getForm();
		$data  = $model->filter($form, $data);
		$result = $model->validate($form, $data);

		if (!$result) {
			$this->app->setUserState('com_items.edit.item.data', $data);
			$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()), 'error');
			$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=' . $id, false));

			return false;
		}

		if (!$model->save($data)) {
			$this->app->setUserState('com_items.edit.item.data', $data);
			$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()), 'error');
			$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=' . $id, false));

			return false;
		}

		$this->app->setUserState('com_items.edit.item.data', null);
		$this->setMessage(Text::_('COM_ITEMS_SAVE_SUCCESS'));
		$this->setRedirect(Route::_('index.php?option=com_items&view=items', false));

		return true;
	}

	public function apply($key = null, $urlVar = null)
	{
		$this->checkToken();

		$model = $this->getModel();
		$data  = $this->input->post->get('jform', [], 'array');
		$id    = (int) ($data['id'] ?? 0);
		$form  = $model->getForm();
		$data  = $model->filter($form, $data);
		$this->app->setUserState('com_items.edit.item.data', $data);
		$result = $model->validate($form, $data);

		if (!$result) {
			$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()), 'error');
			$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=' . $id, false));

			return false;
		}

		if (!$model->save($data)) {
			$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()), 'error');
			$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=' . $id, false));

			return false;
		}

		$this->app->setUserState('com_items.edit.item.data', null);
		$this->setMessage(Text::_('COM_ITEMS_SAVE_SUCCESS'));
		$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=' . $id, false));

		return true;
	}

	public function add()
	{
		$this->setRedirect(Route::_('index.php?option=com_items&view=item&layout=edit&id=0', false));

		return true;
	}
}
