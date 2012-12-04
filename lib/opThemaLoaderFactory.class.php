<?php
/* 
 * ThemaLoaderを作成するためのコードが分散してしまっているのと
 * パスの引数が変更したらインスタンスを作成しているところをすべて変更する必要があるので、
 * ファクトリークラスを作成した
 */

class opThemaLoaderFactory
{
  /**
   *
   * @return opSkinThemaLoader 
   */
  public static function createLoaderInstance()
  {
    $loaderParams = array();
    $loaderParams['web_path']   = sfConfig::get('sf_web_dir').'/opSkinThemaPlugin';
    $loaderParams['thema_path'] = __DIR__.'/../web';

    return new opSkinThemaLoader($loaderParams);
  }
}
