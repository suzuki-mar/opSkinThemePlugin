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
  public function __construct(array $params)
  {
    $this->webPath = $params['web_path'];
    $this->themaPath = $params['thema_path'];
  }

  /**
   * メソッドの結合度を下げるために、レスポンスオブジェクトを引数に渡す
   *
   */
  public function enableSkinByThema($themaName, sfResponse $response)
  {
    if (!$this->existsAssetsByThemaName($themaName))
    {
      $themaName = $this->findSubstitutionThema();
    }

    $this->includeCSSOrJS($themaName, 'css', $response);
    $this->includeCSSOrJS($themaName, 'js', $response);
  }

  private function existsAssetsByThemaName($themaName)
  {
    $themaName = $this->getWebDir() . '/' . $themaName . '/';
    return file_exists($themaName);
  }

  /**
   * 選択したテーマが使用できない場合に代わりのスキンを探す
   */
  private function findSubstitutionThema()
  {
    $pattern = $this->getWebDir() . '/*';

    foreach (glob($pattern, GLOB_ONLYDIR) as $dirPath)
    {
      return str_replace($this->getWebDir(), '', $dirPath);
    }
  }

  /**
   *
   * @todo CSSとJS以外だったら例外を出す
   */
  private function includeCSSOrJS($themaName, $type, sfResponse $response)
  {

    $pattern = $this->getWebDir() . '/' . $themaName . '/' . $type . '/' . '*.' . $type;

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
    $pattern = $this->getThemaPath() . '/*';

    $availableThemaNames = array();
    foreach (glob($pattern, GLOB_ONLYDIR) as $dirPath)
    {
      
      if (preg_match("/op.*Thema$/", $dirPath)) {
        $availableThemaNames[] = pathinfo($dirPath, PATHINFO_FILENAME);
      }
      
    }

    $plugins = array();
    foreach ($availableThemaNames as $name)
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