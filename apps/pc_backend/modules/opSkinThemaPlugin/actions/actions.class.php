<?php

/**
 * opManagerSkinPlugin actions.
 *
 * @package    OpenPNE
 * @subpackage opManagerSkinPlugin
 * @author     Your name here
 */
class opSkinThemaPluginActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $loader = opThemaLoaderFactory::createLoaderInstance();
    $plugins = $loader->loadThemaInsance();

    //既存のプラグインと同じフォームにするために、プラグイン設定画面のフォームを使用する
    $this->form = new opThemaActivationForm(array(), array('plugins' => $plugins));

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
