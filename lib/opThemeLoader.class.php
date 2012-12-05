<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */
error_reporting(error_reporting() & ~(E_STRICT | E_DEPRECATED));

class opThemeLoader extends opInstalledPluginManager
{

  private $webPath;
  private $ThemePath;

  /**
   *
   * @todo 必須パラメーターがない場合は例外を発生させるようにする
   */
  public function __construct(array $params)
  {
    $this->webPath = $params['web_path'];
    $this->ThemePath = $params['theme_path'];
  }

  /**
   * メソッドの結合度を下げるために、レスポンスオブジェクトを引数に渡す
   *
   * @todo Eventクラスに遷移させる
   */
  public function enableSkinByTheme($themeName, sfResponse $response)
  {
    if (!$this->existsAssetsByThemeName($themeName))
    {
      $themeName = $this->findSubstitutionTheme();
    }

    $this->includeCSSOrJS($themeName, 'css', $response);
    $this->includeCSSOrJS($themeName, 'js', $response);
  }

  private function existsAssetsByThemeName($themeName)
  {
    $themeName = $this->getWebDir().'/'.$themeName;
    return file_exists($themeName);
  }

  /**
   * 選択したテーマが使用できない場合に代わりのスキンを探す
   */
  private function findSubstitutionTheme()
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
  private function includeCSSOrJS($themeName, $type, sfResponse $response)
  {

    $pattern = $this->getWebDir().'/'.$themeName.'/'.$type.'/'.'*.'.$type;

    $files = array();
    foreach (glob($pattern) as $fileName)
    {
      $files[] = str_replace($this->getWebDir(), '/opSkinThemePlugin', $fileName);
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

  public function loadThemeInsance()
  {
    $pattern = $this->getThemePath() . '/*';

    $availableThemeNames = array();
    foreach (glob($pattern, GLOB_ONLYDIR) as $dirPath)
    {
      //main.cssがないものはテーマディレクトリとして扱わない
      $mainCssPath = $dirPath.'/css/main.css';
      if (file_exists($mainCssPath)) {
        $availableThemeNames[] = pathinfo($dirPath, PATHINFO_FILENAME);
      }
      
    }

    $plugins = array();
    foreach ($availableThemeNames as $name)
    {
      $plugins[$name] = opTheme::getInstance($name);
    }

    return $plugins;
  }

  public function getThemePath()
  {
    return $this->ThemePath;
  }

  public function getWebDir()
  {
    return $this->webPath;
  }

}