<?php

class opSkinThemaEvent
{

  public static function enableThema(sfEvent $event)
  {
    if (self::isPrviewModule()) {
      return false;
    }

    $themaInfo = new opSkinThemaInfo();
    $skinThema = $themaInfo->findUseTehama();

    self::applyThema($skinThema);
  }

  public static function enablePreviewThema(sfEvent $event)
  {

    if (!self::isPrviewModule()) {
      return false;
    }

    $request = sfContext::getInstance()->getRequest();
    $skinThema = $request->getParameter('skin_name');

    self::applyThema($skinThema);
  }

  private static function applyThema($skinThema)
  {
    $themaLoader = opThemaLoaderFactory::createLoaderInstance();
    $response = sfContext::getInstance()->getResponse();
    $themaLoader->enableSkinByThema($skinThema, $response);
  }

  private static function isPrviewModule()
  {
    return (sfContext::getInstance()->getModuleName() === 'skinpreview');
  }
}
