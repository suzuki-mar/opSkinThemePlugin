<?php

/**
* This file is part of the OpenPNE package.
* (c) OpenPNE Project (http://www.openpne.jp/)
*
* For the full copyright and license information, please view the LICENSE
* file and the NOTICE file that were distributed with this source code.
*/

/**
* 使用するテーマをプレビュー表示する
*
* @package OpenPNE
* @subpackage theme
* @author suzuki_mar <supasu145@gmail.com>
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

    $this->isExistsTheme = $themeSearch->existsAssetsByThemeName($this->themeName);

    $this->emptyThemeName = ($this->themeName === null);
  }

}
