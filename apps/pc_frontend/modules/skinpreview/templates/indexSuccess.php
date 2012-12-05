
<?php if ($isExistsTheme): ?>
  <p><?php echo $themeName.'テーマをプレビュー表示しています'; ?></p>
<?php elseif ($emptyThemeName): ?>
  <p>テーマ名のパラメーターが空です</p>
<?php else: ?>
  <p><?php echo $themeName.'テーマはありません'; ?></p>
<?php endif; ?>
