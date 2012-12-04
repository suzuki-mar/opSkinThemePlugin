<?php

class opSkinThemaInfo
{

  /**
   * @todo テーマがひとつも有効になっていない場合にエラーになる
   */
  public function findUseTehama()
  {
    return $this->_findThemaUsedInstance()->getValue();
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
