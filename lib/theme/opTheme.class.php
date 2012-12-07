<?php

/*
 * opPluginはプラグインを前提にして作られたものなので、
 * テーマ用のクラスを作成した
 */

class opTheme
{

  public static function getInstance($name)
  {
    $instance = new self($name);
    return $instance;
  }

  private
  $themeDirName;

  /**
   * 複数回設定ファイルを読みこまなくてすむようにするため
   * @var array
   */
  private $themeInfo = array();

  public function __construct($name)
  {
    $this->themeDirName = $name;

    $parser = new opThemeInfoParser();
    $this->themeInfo = $parser->parseInfoFileByThemeName($this->themeDirName);

  }

  /**
   * ディレクトリを検索したりするときに使用するので、
   * テーマ名とは別に用意しておく
   */
  public function getThemeDirName()
  {
    return $this->themeDirName;
  }

  /**
   * テーマファイルのテーマ名を変更しても、名前が変わらなかったらエラーみたいな感じになってしまうので
   * テーマ名はテーマファイルに定義してある情報を使用する
   */
  public function getThemeName()
  {
    return $this->themeInfo['theme_name'];
  }

  public function getThemeURI()
  {
    return $this->themeInfo['theme_uri'];
  }

  public function getDescription()
  {
    return $this->themeInfo['description'];
  }

  public function getAuthor()
  {
    return $this->themeInfo['author'];
  }

  public function getVersion()
  {
    return $this->themeInfo['version'];
  }


  public function existsInfoFile()
  {
    return ($this->themeInfo !== false);
  }
}
