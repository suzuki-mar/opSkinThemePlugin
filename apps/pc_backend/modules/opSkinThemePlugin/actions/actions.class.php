<?php

/**
 * opManagerSkinPlugin actions.
 *
 * @package    OpenPNE
 * @subpackage opManagerSkinPlugin
 * @author     Your name here
 */
class opSkinThemePluginActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $loader = opThemeLoaderFactory::createLoaderInstance();
    $themes = $loader->loadThemeInsance();

    //既存のプラグインと同じフォームにするために、プラグイン設定画面のフォームを使用する
    $this->form = new opThemeActivationForm(array(), array('themes' => $themes));

    if ($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($this->request->getParameter('theme_activation'));
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
