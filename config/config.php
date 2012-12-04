<?php

$this->dispatcher->connect('op_action.post_execute', array('opSkinThemaEvent', 'enableThema'));
$this->dispatcher->connect('op_action.post_execute', array('opSkinThemaEvent', 'enablePreviewThema'));