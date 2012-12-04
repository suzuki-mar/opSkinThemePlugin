<?php
/* 
 * opPluginはプラグインを前提にして作られたものなので、
 * テーマ用のクラスを作成した
 */

class opSkinThema
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
  private $themaInfo = array();

  public function  __construct()
  {
    $this->loader = opThemaLoaderFactory::createLoaderInstance();
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
    if (!empty($this->themaInfo)) {
      return $this->themaInfo;
    }

    $themaPath = $this->loader->getThemaPath().'/'.$this->name.'/thema.yml';
    $this->themaInfo = sfYaml::load($themaPath);
    return $this->themaInfo;
  }

}
