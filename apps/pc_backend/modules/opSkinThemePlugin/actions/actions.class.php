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
   * @var opThemeLoader
   */
  private $loader;
  /**
   * 登録してあるテーマ一覧
   */
  private $themes;

  public function preExecute()
  {
    parent::preExecute();

    $this->loader = opThemeLoaderFactory::createLoaderInstance();
  }

  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->themes = $this->loader->loadThemeInsance();

    $config = new opThemeConfig();
    $this->useTheme = $config->findUseTehama();
    $this->existsUseTheme = $this->loader->existsAssetsByThemeName($config->findUseTehama());

    if ($this->existsNotInfoTheme())
    {
      $this->notInfoThemeList = $this->findNotInfoThemeNames();
    }

    $this->isExistsErrorTheme = (isset($this->notInfoThemeList) || $this->existsUseTheme === false);

    //既存のプラグインと同じフォームにするために、プラグイン設定画面のフォームを使用する
    $this->form = new opThemeActivationForm(array(), array('themes' => $this->themes));

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

  private function existsNotInfoTheme()
  {
    foreach ($this->themes as $theme)
    {
      if (!$theme->existsInfoFile())
      {
        return true;
      }
    }

    return false;
  }

  private function findNotInfoThemeNames()
  {
    $notInfoList = array();
    foreach ($this->themes as $theme)
    {
      if (!$theme->existsInfoFile())
      {
        $notInfoList[] = $theme->getName();
      }
    }

    return $notInfoList;
  }

}
