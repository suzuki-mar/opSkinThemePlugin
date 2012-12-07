<?php

/**
* This file is part of the OpenPNE package.
* (c) OpenPNE Project (http://www.openpne.jp/)
*
* For the full copyright and license information, please view the LICENSE
* file and the NOTICE file that were distributed with this source code.
*/

/**
* 設定ファイルを読み込んでテーマ情報をパースするクラス
*
* @package OpenPNE
* @subpackage theme
* @author suzuki_mar <supasu145@gmail.com>
*/

/**
 * 設定ファイルを読み込む処理は複雑なので、クラスを作成した
 */

class opThemeInfoParser
{

  /**
   * @var opThemeLoader
   */
  private $loader;

  public function __construct()
  {
    $this->loader = opThemeLoaderFactory::createLoaderInstance();
  }

  private function getConfigNames()
  {
    return array(
        'Theme Name',
        'Theme URI',
        'Description',
        'Author',
        'Version',
    );
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
          $key = $this->toConfigKeyByConfigName($name);

          $configs[$key] = $value;
        }
      }
    }

    return $configs;
  }

  private function toConfigKeyByConfigName($configName)
  {
    $configKey = '';

    $strs = preg_split("/[\s]+/", $configName, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($strs as $str)
    {
      //空白文字で区切るときに文字化けがおこってしまっているので、文字コードを変更して文字化けを修正する
      //コンフィグ名はすべて英字なのでASCIIを指定してする
      $str = mb_convert_encoding($str, 'ASCII');
      $configKey .= strtolower($str).'_';
    }

    $configKey = substr($configKey, 0, -1);

    return $configKey;
  }

  private function isConfigLines(array $lines)
  {
    $configCount = count($this->getConfigNames());

    //コメントブロックの先頭と終了分も追加する
    if (count($lines) !== $configCount + 2)
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
      $exsitsConfig = false;

      foreach ($configLines as $line)
      {
        $configNameFiled = $name.':';

        if (strpos($line, $configNameFiled) !== false)
        {
          $exsitsConfig = true;
        }
      }

      if (!$exsitsConfig) {
        return false;
      }

    }

    return true;
  }

}
