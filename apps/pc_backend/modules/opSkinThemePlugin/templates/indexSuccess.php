<h2><?php echo __('スキンテーマ設定') ?></h2>

<?php if ($isExistsErrorTheme): ?>
  <h3><?php echo __('テーマのエラー情報') ?></h3>

  <?php if (!$existsUseTheme): ?>
    <p><?php echo '使用しているテーマの'.$useTheme.'が公開ディレクトリにありません' ?></p>
    <?php if (isset($notInfoThemeList)): //行詰めで表示されてしまうので改行する?>
      <br />
    <?php endif; ?>
  <?php endif; ?>

  <?php if (isset($notInfoThemeList)): ?>
    <p><?php echo __('以下のテーマの情報が設定されていません') ?><br />
    <?php foreach ($notInfoThemeList as $theme): ?>
      <?php echo __($theme.'テーマ') ?> <br />
    <?php endforeach; ?>
    </p>
  <?php endif; ?>

<br />
<?php endif; ?>

<p><?php echo __('スキンプテーマはどれか一つのみが「有効」になっている必要があります。') ?></p>
<?php echo $form->renderFormTag(url_for('opSkinThemePlugin/index')); ?>
<table>
<tr>
<th><?php echo __('選択') ?></th>
<th><?php echo __('テーマ名') ?></th>
<th><?php echo __('テーマのURI') ?></th>
<th><?php echo __('制作者') ?></th>
<th><?php echo __('バージョン') ?></th>
<th><?php echo __('テーマの説明') ?></th>
<th><?php echo __('プレビュー') ?></th>
</tr>
<?php echo $form['theme']->render() ?>
<tr>
<td colspan="8">
<?php echo $form->renderHiddenFields() ?>
<input type="submit" value="<?php echo __('設定変更') ?>" />
</td>
</tr>
</table>
</form>

<h2><?php echo __('プラグインの追加') ?></h2>

<p><?php echo __('プラグインはプラグイン配布ページからダウンロードすることができます。') ?></p>
<p><?php echo __('ダウンロードしたファイルを解凍し、サーバ上の plugins ディレクトリにアップロードすることでプラグインがインストールできます。') ?></p>
<p><?php echo __('また、 opPlugin:install コマンドを実行することでもインストール可能です。') ?></p>
