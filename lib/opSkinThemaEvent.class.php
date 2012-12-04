<?php

class opSkinThemaEvent
{

  /**
   * フィルターから呼び出される
   */
  public static function enableThema(sfEvent $event)
  {
    $loaderParams = array();
    $loaderParams['web_path']   = sfConfig::get('sf_web_dir');
    $loaderParams['thema_path'] = __DIR__.'/../thema';
    $themaLoader = new opSkinThemaLoader($loaderParams);

    $pluginModel = new opSkinThemaInfo();
    $skinThema = $pluginModel->findUseSkinTehama();
    $response = sfContext::getInstance()->getResponse();

    $themaLoader->enableSkinByThema($skinThema, $response);
  }

}
