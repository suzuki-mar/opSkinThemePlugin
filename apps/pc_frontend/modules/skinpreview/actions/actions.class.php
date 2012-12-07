<?php

/**
 * preview actions.
 *
 * @package    OpenPNE
 * @subpackage preview
 * @author     Your name here
 */
class skinpreviewActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $themeSearch = opThemeAssetSearchFactory::createSearchInstance();

    $this->themeName = $this->getRequest()->getParameterHolder()->get('theme_name');

    $this->isExistsTheme = $themeLoader->existsAssetsByThemeName($this->themeName);

    $this->emptyThemeName = ($this->themeName === null);
  }

}
