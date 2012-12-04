<?php

$this->dispatcher->connect('op_action.post_execute', array('opThemeEvent', 'enableTheme'));
$this->dispatcher->connect('op_action.post_execute', array('opThemeEvent', 'enablePreviewTheme'));