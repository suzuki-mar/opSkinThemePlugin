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
  public function createSkinPluginInstance()
  {
    
  }

  public static function enableSkin(sfEvent $event)
  {
    $response = sfContext::getInstance()->getResponse();

    //opPluginモデル(DBと関連がないやつ)だと、プラグインディレクトリに入っているかで、有効化を見ているので
    //スキンプラグイン管理ではopPluginモデルは使用できない

    $query = Doctrine::getTable('Plugin')->createQuery('p')->where('p.is_enabled = 1');

    foreach ($query->execute() as $plugin) {
      
      if (preg_match('/^opSkin/', $plugin->getName()) !== false) {
        $skinThema = $plugin->getName();
      }

    }

    $response->addStylesheet('/'.$skinThema.'/css/main.css', 'last');
  }

  public static function loadPluginInsance()
  {
    $pluginNames = array(
        'opSkinBasicPlugin',
        'opSkinSamplePlugin',
        'opSkinHogePlugin',
        'opSKinFugaPlugin',
    );

    $plugins = array();
    foreach ($pluginNames as $name)
    {
      $plugins[$name] = opPlugin::getInstance($name);
    }

    return $plugins;
  }
}