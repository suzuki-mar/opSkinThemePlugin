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
   * @todo スキンプラグイン管理ディレクトリから取得するようにする
   */
  public function executeIndex(sfWebRequest $request)
  {
    $loader = new opSkinPluginLoader();
//    var_dump($loader->getInstalledApplicationPlugins());
//    exit;


    

    $plugins = $loader->loadPluginInsance();


    //$this->form = new PluginActivationForm(array(), array('plugins' => $this->plugins, 'type' => $this->type));
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
