<?php

/**
 * opManagerSkinPlugin actions.
 *
 * @package    OpenPNE
 * @subpackage opManagerSkinPlugin
 * @author     Your name here
 */
class opManagerSkinPluginActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $loader = new opSkinPluginLoader();
    $plugins = $loader->loadPluginInsance();

    //既存のプラグインと同じフォームにするために、プラグイン設定画面のフォームを使用する
    require_once sfConfig::get('sf_apps_dir') . '/pc_backend/modules/plugin/lib/PluginActivationForm.class.php';
    $this->form = new PluginActivationForm(array(), array('plugins' => $plugins, 'type' => 'skin'));

    if ($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($this->request->getParameter('plugin_activation'));
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('notice', 'Saved.');
        $this->form->save();
      }
      else
      {
        $this->getUser()->setFlash('error', $this->form->getErrorSchema()->getMessage());
      }
    }
  }

}
