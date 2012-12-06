<?php if ($isExistsTheme): ?>
  <p><?php echo __($themeName.'テーマをプレビュー表示しています') ?></p>
<?php elseif ($emptyThemeName): ?>
  <p><?php echo__('テーマ名のパラメーターが空です') ?></p>
<?php else: ?>
  <p><?php echo __($themeName.'テーマはありません') ?></p>
<?php endif; ?>
