<?php

class opThemeConfig
{

  /**
   * @todo メソッド名を修正する
   */
  public function findUseTheme()
  {
    if ($this->_findThemeUsedInstance() === null) {
      return null;
    }

    return $this->_findThemeUsedInstance()->getValue();
  }

  public function registeredUsedTheme()
  {
    return ($this->_findThemeUsedInstance() !== null);
  }

  public function unRegisteredisTheme()
  {
    return!($this->registeredUsedTheme());
  }

  public function save($ThemeName)
  {
    if ($this->registeredUsedTheme())
    {
      $themeUsed = $this->_findThemeUsedInstance();
    }
    else
    {
      $themeUsed = new SnsConfig();
      $themeUsed->setName('Theme_used');
    }

    $themeUsed->setValue($ThemeName);
    $themeUsed->save();
    return true;
  }

  private function _findThemeUsedInstance()
  {
    $snsConfigTable = Doctrine::getTable('SnsConfig');
    return $snsConfigTable->retrieveByName('Theme_used');
  }

}
