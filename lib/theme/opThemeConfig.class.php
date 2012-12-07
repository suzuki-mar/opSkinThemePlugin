<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * テーマの設定値(使用するテーマなど)を管理するクラス
 *
 * @package OpenPNE
 * @subpackage theme
 * @author suzuki_mar <supasu145@gmail.com>
 */

/**
 * 新しくテーブルを作成するのは、プラグインとしてはやりすぎなので、
 * sns_configテーブルに設定値を登録している
 *
 * ただ本体に取り込まれてテーブルを作成することができるようになったら
 * themeテーブルを作成した方が拡張しやすくなると思う
 *
 */
class opThemeConfig
{

  /**
   * 新しくテーブルを作成するのは、プラグインとしてはやりすぎなので、
   * ただ本体に取り込まれてテーブルを作成することができるようになったら
   * themeテーブルを作成した方がいい
   *
   */
  public function findUseTheme()
  {
    if ($this->_findThemeUsedInstance() === null)
    {
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
