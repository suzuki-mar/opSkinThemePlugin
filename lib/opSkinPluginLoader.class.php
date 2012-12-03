<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */
error_reporting(error_reporting() & ~(E_STRICT | E_DEPRECATED));

class opSkinPluginLoader extends opInstalledPluginManager
{

  public static function enableSkin(sfEvent $event)
  {
    $skinThema = self::findUseSkinTehama();
    self::includeCSSOrJs($skinThema, 'css');
    self::includeCSSOrJs($skinThema, 'js');

    $response = sfContext::getInstance()->getResponse();
  }

  /**
   * プラグインのため、プラグインクラスに定義してるがモデルに移動できるのであれば移動した方がいい
   *
   * @todo プラグインがひとつも有効になっていない場合にエラーになる
   */
  private static function findUseSkinTehama()
  {
    //opPluginモデル(DBと関連がないやつ)だと、プラグインディレクトリに入っているかで、有効化を見ているので
    //スキンプラグイン管理ではopPluginモデルは使用できない

    $query = Doctrine::getTable('Plugin')->createQuery('p')->where('p.is_enabled = 1');

    foreach ($query->execute() as $plugin)
    {

      if (preg_match('/^opSkin/', $plugin->getName()) !== false)
      {
        $skinThema = $plugin->getName();
        break;
      }
    }

    return $skinThema;
  }

  /**
   *
   * @todo CSSとJS以外だったら例外を出す
   */
  private static function includeCSSOrJS($skinThema, $type)
  {

    $cssDir = $skinThema . '/' . $type . '/';

    $pattern = sfConfig::get('sf_web_dir') . '/' . $cssDir . '*.' . $type;

    $files = array();
    foreach (glob($pattern) as $fileName)
    {
      $files[] = str_replace(sfConfig::get('sf_web_dir'), '', $fileName);
    }

    $response = sfContext::getInstance()->getResponse();

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

  public static function loadPluginInsance()
  {
    $pattern = __DIR__ . '/../thema/*';

    $availableSkinNames = array();
    foreach (glob($pattern, GLOB_ONLYDIR) as $dirName)
    {
      $availableSkinNames[] = pathinfo($dirName, PATHINFO_FILENAME);
    }


    $plugins = array();
    foreach ($availableSkinNames as $name)
    {
      $plugins[$name] = opPlugin::getInstance($name);
    }

    return $plugins;
  }

}