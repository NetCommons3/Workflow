<?php
/**
 * Workflow Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Workflow Helper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Workflow\View\Helper
 */
class WorkflowHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.NetCommonsForm',
		'NetCommons.BackHtml',
	);

/**
 * Output status label url
 *
 * @param int $status Status label
 * @return string Cancel url
 */
	public function label($status) {
		$labels = array(
			WorkflowComponent::STATUS_IN_DRAFT => array(
				'class' => 'label-info',
				'message' => __d('net_commons', 'Temporary'),
			),
			WorkflowComponent::STATUS_APPROVED => array(
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Approving'),
			),
			WorkflowComponent::STATUS_DISAPPROVED => array(
				'class' => 'label-warning',
				'message' => __d('net_commons', 'Disapproving'),
			),
		);

		$output = '';
		if (isset($labels[$status])) {
			$output .= '<span class="label ' . $labels[$status]['class'] . '">' . $labels[$status]['message'] . '</span>';
		}
		return $output;
	}

/**
 * Output workflow buttons
 *
 * @param string $statusFieldName This should be "Modelname.fieldname"
 * @param string|null $cancelUrl Cancel url
 * @param bool $panel If true is add to panel footer div, then false is not div.
 * @return string Cancel url
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function buttons($statusFieldName, $cancelUrl = null, $panel = true) {
		$status = Hash::get($this->data, $statusFieldName);

		$output = '';
		if ($panel) {
			$output .= '<div class="panel-footer text-center">';
		}

		if (! isset($cancelUrl)) {
			$cancelUrl = Current::backToIndexUrl();
		}

		$output .= $this->Html->link(
			'<span class="glyphicon glyphicon-remove"></span> ' . __d('net_commons', 'Cancel'),
			$cancelUrl,
			array('class' => 'btn btn-default btn-workflow', 'escape' => false)
		);

		if (Current::permission('content_publishable') && $status === WorkflowComponent::STATUS_APPROVED) {
			$output .= $this->Form->button(
				__d('net_commons', 'Disapproval'),
				array(
					'class' => 'btn btn-warning btn-workflow',
					'name' => 'save_' . WorkflowComponent::STATUS_DISAPPROVED,
				));
		} else {
			$output .= $this->Form->button(
				__d('net_commons', 'Save temporally'),
				array(
					'class' => 'btn btn-info btn-workflow',
					'name' => 'save_' . WorkflowComponent::STATUS_IN_DRAFT,
				));
		}

		if (Current::permission('content_publishable')) {
			$output .= $this->Form->button(
				__d('net_commons', 'OK'),
				array(
					'class' => 'btn btn-primary btn-workflow',
					'name' => 'save_' . WorkflowComponent::STATUS_PUBLISHED,
				));
		} else {
			$output .= $this->Form->button(
				__d('net_commons', 'OK'),
				array(
					'class' => 'btn btn-primary btn-workflow',
					'name' => 'save_' . WorkflowComponent::STATUS_APPROVED,
				));
		}

		if ($panel) {
			$output .= '</div>';
		}

		return $output;
	}

/**
 * Output workflow input comment
 *
 * @param string $statusFieldName This should be "Modelname.fieldname"
 * @param bool $panel If true is add to panel footer div, then false is not div.
 * @return string Cancel url
 */
	public function inputComment($statusFieldName) {
		$status = Hash::get($this->_View->data, $statusFieldName);
		return $this->_View->element('Comments.form', array(
			'contentPublishable' => Current::permission('content_publishable'),
			'contentStatus' => $status,
		));
	}

/**
 * Output workflow input comment
 *
 * @return string Cancel url
 */
	public function comments() {
		if (! isset($this->_View->viewVars['comments'])) {
			$this->_View->viewVars['comments'] = array();
		}

		return $this->_View->element('Comments.index', array(
			'comments' => $this->_View->viewVars['comments']
		));
	}

/**
 * Check editable permission
 *
 * @param string $modelName This should be "Pluginname.Modelname"
 * @param array $data Model data
 * @return bool True is editable data
 */
	public function canEdit($name, $data) {
		list($plugin, $model) = pluginSplit($name);
		if (! $plugin) {
			$plugin = Inflector::pluralize(Inflector::classify($this->request->params['plugin']));
		}
		${$model} = ClassRegistry::init($plugin . '.' . $model);

		return ${$model}->canEditWorkflowContent($data);
	}

/**
 * Check deletable permission
 *
 * @param string $name This should be "Pluginname.Modelname"
 * @param array $data Model data
 * @return bool True is editable data
 */
	public function canDelete($name, $data) {
		list($plugin, $model) = pluginSplit($name);
		if (! $plugin) {
			$plugin = Inflector::pluralize(Inflector::classify($this->request->params['plugin']));
		}
		${$model} = ClassRegistry::init($plugin . '.' . $model);

		return ${$model}->canDeleteWorkflowContent($data);
	}

}
