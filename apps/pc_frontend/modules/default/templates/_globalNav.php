<?php if ($navs && 0 < count($navs)): ?>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<b class="caret"></b>
</a>
<ul class="dropdown-menu">
<?php foreach ($navs as $nav): ?>
<?php if (op_is_accessible_url($nav->uri)): ?>
<?php if('@member_profile_mine' === $nav->uri): ?>
<li id="globalNav_<?php echo op_url_to_id($nav->uri, true) ?>"><?php echo link_to($memberName, $nav->uri) ?></li>
<?php else: ?>
<li id="globalNav_<?php echo op_url_to_id($nav->uri, true) ?>"><?php echo link_to($nav->caption, $nav->uri) ?></li>
<?php endif ?>
<?php endif; ?>
<?php endforeach; ?>
</ul>
</li>
<?php endif; ?>