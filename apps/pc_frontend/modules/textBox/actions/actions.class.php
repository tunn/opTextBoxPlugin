<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * textBox actions.
 *
 * @package    OpenPNE
 * @subpackage textBox
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class textBoxActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeUpdateText($request)
  {
    if ($request->isMethod(sfWebRequest::POST))
    {
      $this->forward404Unless(opConfig::get('is_allow_post_activity'));
      $newObject = new TextBox();
      $newObject->setMemberId($this->getUser()->getMemberId());
      $this->form = new TextBoxForm($newObject);
      $params = $request->getParameter('text_box');
      $bitly = new Bitly('houushuu', 'R_1c83f7593df310831f1c290daab8fd35');
      $params['content'] = $bitly->shortenSingle($params['content']);
      $this->form->bind($params);
      if ($this->form->isValid())
      {
        $this->form->save();
        
        if (3 == $params['type'])
        {      
          if ($this->getUser()->hasAttribute('sfTwitterAuth_oauth_access_token') &&
          $this->getUser()->hasAttribute('sfTwitterAuth_oauth_access_token_secret'))
          {
            sfTwitterAPI::tweet($params['content']);
          } 
          else
          {
            echo "false";
            $this->redirect('http://sns1.bkec.org/sfTwitterAuth/login');
          }
        }
        
        if ($request->isXmlHttpRequest())
        {
          $textList = Doctrine::getTable('TextBox')->getTextList();
          $this->getContext()->getConfiguration()->loadHelpers('Partial');
          return $this->renderText(get_partial('textBox/textRecord', array('text' => $this->form->getObject())));
        }
      }
      else
      {
        if ($request->isXmlHttpRequest())
        {
          $this->getResponse()->setStatusCode(500);
        }
        else
        {
          $this->redirect('@homepage');
        }
      }
    }
    return sfView::NONE;
  }
  
  public function executeDeleteText($request)
  {
    $this->forward404Unless($request->hasParameter('id'));
    echo $this->id;
    $this->text = Doctrine::getTable('TextBox')->find($request->getParameter('id'));
    $this->forward404Unless($this->text->getMemberId() == $this->getUser()->getMemberId());

    if ($request->isMethod(sfWebRequest::POST))
    {
      $request->checkCSRFProtection();
      $this->text->delete();
      $this->getUser()->setFlash('notice', 'An text has been deleted.');
      $this->redirect('textBox/textBox');
    }

    return sfView::INPUT;
  }
}
