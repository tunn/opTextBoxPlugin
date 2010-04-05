<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class textBoxComponents extends sfComponents
{
  public function executeTextBox()
  {
    $this->textList = Doctrine::getTable('TextBox')->getTextList($this->getUser()->getMemberId(), $this->gadget->getConfig('row'));
    if (opConfig::get('is_allow_post_activity'))
    {
      $this->form = new TextBoxForm();
    }
  }
}