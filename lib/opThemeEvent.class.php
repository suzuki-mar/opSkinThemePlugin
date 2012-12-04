<?php

class opThemeEvent
{

  public static function enableTheme(sfEvent $event)
  {
    if (self::isPrviewModule()) {
      return false;
    }

    $themeInfo = new opThemeInfo();
    $skinTheme = $themeInfo->findUseTehama();

    self::applyTheme($skinTheme);
  }

  public static function enablePreviewTheme(sfEvent $event)
  {

    if (!self::isPrviewModule()) {
      return false;
    }

    $request = sfContext::getInstance()->getRequest();
    $skinTheme = $request->getParameter('theme_name');

    self::applyTheme($skinTheme);
  }

  private static function applyTheme($skinTheme)
  {
    $ThemeLoader = opThemeLoaderFactory::createLoaderInstance();
    $response = sfContext::getInstance()->getResponse();
    $ThemeLoader->enableSkinByTheme($skinTheme, $response);
  }

  private static function isPrviewModule()
  {
    return (sfContext::getInstance()->getModuleName() === 'skinpreview');
  }
}
