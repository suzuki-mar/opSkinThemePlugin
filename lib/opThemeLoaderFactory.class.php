<?php
/* 
 * ThemeLoaderを作成するためのコードが分散してしまっているのと
 * パスの引数が変更したらインスタンスを作成しているところをすべて変更する必要があるので、
 * ファクトリークラスを作成した
 */

class opThemeLoaderFactory
{
  /**
   *
   * @return opSkinThemeLoader
   */
  public static function createLoaderInstance()
  {
    $loaderParams = array();
    $loaderParams['web_path']   = sfConfig::get('sf_web_dir').'/opSkinThemePlugin';
    $loaderParams['theme_path'] = __DIR__.'/../web';

    return new opThemeLoader($loaderParams);
  }
}
