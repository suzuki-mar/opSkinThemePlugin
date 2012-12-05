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
  $name,
  $loader;

  /**
   * 複数回設定ファイルを読みこまなくてすむようにするため
   * @var array
   */
  private $themeInfo = array();

  public function  __construct($name)
  {
    $this->loader    = opThemeLoaderFactory::createLoaderInstance();
    
    $this->name = $name;

    $themePath = realpath($this->loader->getThemePath().'/'.$this->name.'/theme.yml');
    $this->themeInfo = sfYaml::load($themePath);
  }

  public function getName()
  {
    return $this->name;
  }

  public function getVersion()
  {
    return $this->themeInfo['version'];
  }

  public function getSummary()
  {
    return $this->themeInfo['summary'];
  }

}
