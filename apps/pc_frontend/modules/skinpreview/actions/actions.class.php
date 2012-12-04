<?php

/**
 * preview actions.
 *
 * @package    OpenPNE
 * @subpackage preview
 * @author     Your name here
 */
class skinpreviewActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    opSkinPluginLoader::enablePreviewSkin('opSkinBasic');
  }
}
