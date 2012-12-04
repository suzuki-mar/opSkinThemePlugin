<?php

class opSkinThemaInfo
{

  /**
   * @todo テーマがひとつも有効になっていない場合にエラーになる
   */
  public function findUseSkinTehama()
  {
    //opPluginモデル(DBと関連がないやつ)だと、プラグインディレクトリに入っているかで、有効化を見ているので
    //スキンプラグイン管理ではopPluginモデルは使用できない

    $query = Doctrine::getTable('Plugin')->createQuery('p')->where('p.is_enabled = 1');

    foreach ($query->execute() as $plugin)
    {

      if (preg_match('/^opSkin/', $plugin->getName()) !== false)
      {
        $skinThema = $plugin->getName();
        break;
      }
    }

    return $skinThema;
  }

  public function isThemaSelected()
  {
    return ($this->_findThemaUsedInstance() !== null);
  }

  public function isThemaUnSelected()
  {
    return!($this->isThemaSelected());
  }

  public function save($themaName)
  {
    if ($this->isThemaSelected())
    {
      $themaUsed = $this->_findThemaUsedInstance();
    }
    else
    {
      $themaUsed = new SnsConfig();
      $themaUsed->setName('Thema_used');
    }

    $themaUsed->setValue($themaName);
    $themaUsed->save();
    return true;
  }

  private function _findThemaUsedInstance()
  {
    $snsConfigTable = Doctrine::getTable('SnsConfig');
    return $snsConfigTable->retrieveByName('Thema_used');
  }

}
