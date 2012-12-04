<?php

/**
 * プラグインのため、プラグインディレクトリに定義してるが本体に取り込まれたらモデルに移動できるのであれば移動した方がいい
 */
class opSkinThemaPlugin
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

}
