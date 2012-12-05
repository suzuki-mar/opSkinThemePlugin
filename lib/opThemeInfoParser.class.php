<?php

class opThemeInfoParser
{

  /**
   * @var opThemeLoader
   */
  private $loader;
  
  public function  __construct()
  {
    $this->loader = opThemeLoaderFactory::createLoaderInstance();
  }
  
  //処理が大きすぎるので、クラスにした方がいいと思う 移譲して
  public function parseInfoFileByThemeName($themeName)
  {
    $infoPath = $this->loader->getThemePath().'/'.$themeName.'/css/main.css';
    $fp = fopen($infoPath, 'r');

    if (!$fp)
    {
      fclose($fp);
      return false;
    }

    $configLines = $this->clipConfigLines($fp);

    if ($configLines === false)
    {
      return false;
    }

    return $this->parseConfigLines($configLines);
  }

  private function clipConfigLines($fp)
  {
    $commentLineStart = false;

    while (!feof($fp))
    {
      $line = trim(fgets($fp));

      if (strpos($line, '/*') !== false)
      {
        $commentLineStart = true;
      }

      if ($commentLineStart)
      {
        $configLines[] = $line;
      }


      if (strpos($line, '*/') !== false)
      {

        if ($this->isConfigLines($configLines))
        {
          //ブロックの開始と終了は削除する
          array_shift($configLines);
          array_pop($configLines);

          fclose($fp);
          return $configLines;
        }

        $commentLineStart = false;
        //配列に行がどんどん追加されてしまう
        $configLines = array();
      }
    }

    fclose($fp);
    return false;
  }

  private function parseConfigLines(array $configLines)
  {
    $configs = array();
    foreach ($this->getConfigNames() as $name)
    {
      foreach ($configLines as $line)
      {
        $configNameFiled = $name.':';

        if (strpos($line, $configNameFiled) !== false)
        {
          $value = str_replace($configNameFiled, '', $line);

          $configName = strtolower($name);
          $configs[$configName] = $value;
        }
      }
    }

    //説明文は最後の行にある
    $configs['summary'] = array_pop($configLines);

    return $configs;
  }

  private function getConfigNames()
  {
    return array('Version');
  }

  const CONFIG_COUNT = 2;

  private function isConfigLines(array $lines)
  {
    //コメントブロックの先頭と終了分も追加する
    if (count($lines) !== self::CONFIG_COUNT + 2)
    {
      return false;
    }

    $configLines = array();
    //コメントブロックは無視する
    for ($i = 1; $i < count($lines) - 1; $i++)
    {
      $configLines[] = $lines[$i];
    }

    //項目が全てない場合はエラーとする
    foreach ($this->getConfigNames() as $name)
    {

      foreach ($configLines as $line)
      {
        $configNameFiled = $name.':';

        if (!strpos($line, $configNameFiled) === false)
        {
          return false;
        }
      }
    }

    return true;
  }

}
