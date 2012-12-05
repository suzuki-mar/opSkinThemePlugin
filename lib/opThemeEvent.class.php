<?php

class opThemeEvent
{

  public static function enableTheme(sfEvent $event)
  {
    if (self::isPrviewModule())
    {
      return false;
    }

    $themeInfo = new opThemeInfo();
    $themeName = $themeInfo->findUseTehama();
    $themeLoader = opThemeLoaderFactory::createLoaderInstance();

    if (!$themeLoader->existsAssetsByThemeName($themeName))
    {
      $themeName = $themeLoader->findSubstitutionTheme();
    }

    self::enableSkinByTheme($themeName);
  }

  public static function enablePreviewTheme(sfEvent $event)
  {

    if (!self::isPrviewModule())
    {
      return false;
    }

    $request = sfContext::getInstance()->getRequest();
    $themeName = $request->getParameter('theme_name');

    if ($themeName === null) {
      return false;
    }

    $themeLoader = opThemeLoaderFactory::createLoaderInstance();

    if (!$themeLoader->existsAssetsByThemeName($themeName))
    {
      return false;
    }

    self::enableSkinByTheme($themeName);
  }

  private static function isPrviewModule()
  {
    return (sfContext::getInstance()->getModuleName() === 'skinpreview');
  }

  public static function enableSkinByTheme($themeName)
  {
    $themeLoader = opThemeLoaderFactory::createLoaderInstance();

    $filePaths = $themeLoader->findAssetsPathByThemeNameAndType($themeName, 'css');
    self::includeCSSOrJS($filePaths, 'css');

    $filePaths = $themeLoader->findAssetsPathByThemeNameAndType($themeName, 'js');
    self::includeCSSOrJS($filePaths, 'js');
  }

  /**
   *
   * @todo CSSとJS以外だったら例外を出す
   */
  private static function includeCSSOrJS($filePaths, $type)
  {
    $response = sfContext::getInstance()->getResponse();

    if ($type === 'css')
    {
      foreach ($filePaths as $file)
      {
        $response->addStylesheet($file, 'last');
      }
    }

    if ($type === 'js')
    {
      foreach ($filePaths as $file)
      {
        $response->addJavaScript($file, 'last');
      }
    }

  }

}
