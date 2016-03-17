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
App::uses('WorkflowComponent', 'Workflow.Controller/Component');

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
		'NetCommons.Button',
		'NetCommons.LinkButton',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css('/workflow/css/style.css');
		parent::beforeRender($viewFile);
	}

/**
 * ステータスのラベル
 *
 * @param int $status スータス
 * @param array $labels Overwrite Status labels
 * @return string ラベルHTML
 */
	public function label($status, $labels = array()) {
		if (empty($labels)) {
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
		}

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
 * @param string|null $backUrl Back url
 * @return string Cancel url
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function buttons($statusFieldName, $cancelUrl = null, $panel = true, $backUrl = null) {
		$status = Hash::get($this->_View->data, $statusFieldName);

		$output = '';
		if ($panel) {
			$output .= '<div class="panel-footer text-center">';
		}

		if (! isset($cancelUrl)) {
			$cancelUrl = NetCommonsUrl::backToIndexUrl();
		}
		$cancelOptions = array(
			'ng-class' => '{disabled: sending}',
			'ng-click' => 'sending=true',
		);

		if (Current::permission('content_publishable') && $status === WorkflowComponent::STATUS_APPROVED) {
			$saveTempOptions = array(
				'label' => __d('net_commons', 'Disapproval'),
				'class' => 'btn btn-warning btn-workflow',
				'name' => 'save_' . WorkflowComponent::STATUS_DISAPPROVED,
				'ng-class' => '{disabled: sending}'
			);
		} else {
			$saveTempOptions = array(
				'label' => __d('net_commons', 'Save temporally'),
				'class' => 'btn btn-info btn-workflow',
				'name' => 'save_' . WorkflowComponent::STATUS_IN_DRAFT,
				'ng-class' => '{disabled: sending}'
			);
		}

		if (Current::permission('content_publishable')) {
			$saveOptions = array(
				'label' => __d('net_commons', 'OK'),
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save_' . WorkflowComponent::STATUS_PUBLISHED,
				'ng-class' => '{disabled: sending}'
			);
		} else {
			$saveOptions = array(
				'label' => __d('net_commons', 'OK'),
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save_' . WorkflowComponent::STATUS_APPROVED,
				'ng-class' => '{disabled: sending}'
			);
		}

		$output .= $this->Button->cancelAndSaveAndSaveTemp($cancelUrl, $cancelOptions, $saveTempOptions, $saveOptions, $backUrl);

		if ($panel) {
			$output .= '</div>';
		}

		return $output;
	}

/**
 * Output workflow input comment
 *
 * @param string $statusFieldName ステータスのフィールド名
 * @param bool $displayBlockKey block_keyを含めるかどうか
 * @return string Html
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function inputComment($statusFieldName, $displayBlockKey = true) {
		$status = Hash::get($this->_View->data, $statusFieldName);

		$output = $this->_View->element('Workflow.form', array(
			'contentPublishable' => Current::permission('content_publishable'),
			'contentStatus' => $status,
		));

		if ($displayBlockKey) {
			$output .= $this->NetCommonsForm->hidden('Block.key', array('value' => Current::read('Block.key')));
		}
		return $output;
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

		return $this->_View->element('Workflow.index', array(
			'comments' => $this->_View->viewVars['comments']
		));
	}

/**
 * Check editable permission
 *
 * @param string $model This should be "Pluginname.Modelname"
 * @param array $data Model data
 * @return bool True is editable data
 */
	public function canEdit($model, $data) {
		list($plugin, $model) = pluginSplit($model);
		if (! $plugin) {
			$plugin = Inflector::pluralize(Inflector::classify($this->request->params['plugin']));
		}
		${$model} = ClassRegistry::init($plugin . '.' . $model);

		return ${$model}->canEditWorkflowContent($data);
	}

/**
 * Check deletable permission
 *
 * @param string $model This should be "Pluginname.Modelname"
 * @param array $data Model data
 * @return bool True is editable data
 */
	public function canDelete($model, $data) {
		list($plugin, $model) = pluginSplit($model);
		if (! $plugin) {
			$plugin = Inflector::pluralize(Inflector::classify($this->request->params['plugin']));
		}
		${$model} = ClassRegistry::init($plugin . '.' . $model);

		return ${$model}->canDeleteWorkflowContent($data);
	}

/**
 * Creates a `<a>` tag for publish link link. The type attribute defaults
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function publishLinkButton($title = '', $options = array()) {
		$output = '';

		//ボタンサイズ
		$sizeAttr = Hash::get($options, 'iconSize', '');
		if ($sizeAttr) {
			$sizeAttr = ' ' . $sizeAttr;
		}
		$options = Hash::remove($options, 'iconSize');

		//Linkオプションの設定
		$inputOptions = Hash::merge(
			array(
				'icon' => 'ok',
				'name' => 'save_' . WorkflowComponent::STATUS_PUBLISHED,
				'class' => 'btn btn-warning' . $sizeAttr
			),
			$options,
			array(
				'escapeTitle' => false,
			)
		);
		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($options['icon']);

		//span tooltipタグの出力
		if (isset($options['tooltip']) && $options['tooltip']) {
			if (is_string($options['tooltip'])) {
				$tooltip = $options['tooltip'];
			} else {
				$tooltip = __d('net_commons', 'Accept');
			}
			$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
			unset($inputOptions['tooltip']);
		}
		$output .= $this->Form->button($iconElement . $title, $inputOptions);
		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
		return $output;
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 *
 * @param string $title The button's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 */
	public function addLinkButton($title = '', $url = null, $options = array()) {
		$output = '';

		if (! Current::permission('content_creatable')) {
			return $output;
		}

		//URLの設定
		$defaultUrl = array(
			'plugin' => $this->_View->request->params['plugin'],
			'controller' => $this->_View->request->params['controller'],
		);
		if (! isset($url)) {
			$url = array(
				'action' => 'add',
				'block_id' => Current::read('Block.id'),
				'frame_id' => Current::read('Frame.id'),
			);
			if (isset($this->_View->viewVars['addActionController'])) {
				$url['controller'] = $this->_View->viewVars['addActionController'];
			}
		}
		$url = Hash::merge($defaultUrl, $url);

		$output = $this->LinkButton->add($title, $url, $options);
		return $output;
	}

}
