<?php

/**
* This file is part of the OpenPNE package.
* (c) OpenPNE Project (http://www.openpne.jp/)
*
* For the full copyright and license information, please view the LICENSE
* file and the NOTICE file that were distributed with this source code.
*/

/**
* opThemeLoaderを作成するためのファクトリークラス
*
* @package OpenPNE
* @subpackage theme
* @author suzuki_mar <supasu145@gmail.com>
*/

/* 
 * ThemeLoaderを作成するためのコードが分散してしまっているのと
 * パスの引数が変更したらインスタンスを作成しているところをすべて変更する必要があるので、
 * ファクトリークラスを作成した
 */

class opThemeAssetSearchFactory
{
  /**
   *
   * @return opSkinThemeAssetSearch
   */
  public static function createSearchInstance()
  {
    $loaderParams = array();
    $loaderParams['web_path']   = sfConfig::get('sf_web_dir').'/opSkinThemePlugin';
    $loaderParams['theme_path'] = __DIR__.'/../../web';

    return new opThemeAssetSearch($loaderParams);
  }
}
