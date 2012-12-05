<?php

class opThemeEvent
{

  public static function enableTheme(sfEvent $event)
  {
    if (!self::isFrontend())
    {
      return false;
    }

    if (self::isPrviewModule())
    {
      return false;
    }

    $themeInfo = new opThemeConfig();

    //使用するテーマが登録されていない場合はテーマを読み込まない
    if ($themeInfo->unRegisteredisTheme())
    {
      sfContext::getInstance()->getUser()->setFlash('error', 'テーマが登録されていません', false);
      return false;
    }

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
    if (!self::isFrontend())
    {
      return false;
    }

    if (!self::isPrviewModule())
    {
      return false;
    }

    $request = sfContext::getInstance()->getRequest();
    $themeName = $request->getParameter('theme_name');

    if ($themeName === null)
    {
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

  private static function isFrontend()
  {
    $application = sfContext::getInstance()->getConfiguration()->getApplication();
    return ($application === 'pc_frontend');
  }

  public static function enableSkinByTheme($themeName)
  {
    $themeLoader = opThemeLoaderFactory::createLoaderInstance();

    $assetsType = array('css', 'js');
    foreach ($assetsType as $type)
    {
      $filePaths = $themeLoader->findAssetsPathByThemeNameAndType($themeName, $type);


      if ($filePaths !== false)
      {
        self::includeCSSOrJS($filePaths, $type);
      }
    }

  }

  /**
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
