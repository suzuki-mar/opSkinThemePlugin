<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */
error_reporting(error_reporting() & ~(E_STRICT | E_DEPRECATED));

class opSkinThemaLoader extends opInstalledPluginManager
{
  private $webPath;
  private $themaPath;

  /**
   *
   * @todo 必須パラメーターがない場合は例外を発生させるようにする
   */
  public function  __construct(array $params)
  {
    $this->webPath = $params['web_path'];
    $this->themaPath  = $params['thema_path'];
  }


  /**
   * メソッドの結合度を下げるために、レスポンスオブジェクトを引数に渡す
   *
   */
  public function enableSkinByThema($skinThema, sfResponse $response)
  {
    $this->includeCSSOrJS($skinThema, 'css', $response);
    $this->includeCSSOrJS($skinThema, 'js',  $response);
  }



  /**
   *
   * @todo CSSとJS以外だったら例外を出す
   */
  private function includeCSSOrJS($skinThema, $type, sfResponse $response)
  {

    $pattern =  $this->getWebDir().'/'.$skinThema.'/'.$type.'/'.'*.'.$type;

    $files = array();
    foreach (glob($pattern) as $fileName)
    {
      $files[] = str_replace($this->getWebDir(), '/opSkinThemaPlugin', $fileName);
    }

    if ($type === 'css')
    {
      foreach ($files as $file)
      {
        $response->addStylesheet($file, 'last');
      }
    }

    if ($type === 'js')
    {
      foreach ($files as $file)
      {
        $response->addJavaScript($file, 'last');
      }
    }
  }

  public function loadThemaInsance()
  {
    $pattern = $this->getThemaPath().'/*';

    $availableSkinNames = array();
    foreach (glob($pattern, GLOB_ONLYDIR) as $dirName)
    {
      $availableSkinNames[] = pathinfo($dirName, PATHINFO_FILENAME);
    }

    $plugins = array();
    foreach ($availableSkinNames as $name)
    {
      $plugins[$name] = opSkinThema::getInstance($name);
    }

    return $plugins;
  }

  public function getThemaPath()
  {
    return $this->themaPath;
  }

  public function getWebDir()
  {
    return $this->webPath;
  }


}