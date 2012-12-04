<?php
/* 
 * opPluginはプラグインを前提にして作られたものなので、
 * テーマ用のクラスを作成した
 */

class opTheme
{
  public static function getInstance($name)
  {
    $instance = new self();
    $instance->setName($name);

    return $instance;
  }

  private $name;
  private $loader;

  /**
   * 複数回設定ファイルを読みこまなくてすむようにするため
   * @var array
   */
  private $themeInfo = array();

  public function  __construct()
  {
    $this->loader = opThemeLoaderFactory::createLoaderInstance();
  }


  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getVersion()
  {
    $info = $this->parseInfoFile();
    return $info['version'];
  }

  public function getSummary()
  {
    $info = $this->parseInfoFile();
    return $info['summary'];
  }

  private function parseInfoFile()
  {
    if (!empty($this->themeInfo)) {
      return $this->themeInfo;
    }

    $themePath = $this->loader->getThemePath().'/'.$this->name.'/theme.yml';
    $this->themeInfo = sfYaml::load($themePath);

    return $this->themeInfo;
  }

}
