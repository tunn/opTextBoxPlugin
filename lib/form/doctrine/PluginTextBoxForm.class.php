<?php

/**
 * PluginTextBox form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginTextBoxForm extends BaseTextBoxForm
{
  public function setup()
  {
    parent::setup();
    
    $this->useFields(array('content', 'type'));
    
    $this->setWidget('content', new sfWidgetFormTextarea()); 
    $this->setValidator('content', new opValidatorString(array('max_length' => 140, 'required' => true, 'trim' => true)));
        
    $choices = $this->getObject()->getTable()->getTypes();
    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => $choices)));
    $this->setValidator('type', new sfValidatorChoice(array('choices' => array_keys($choices))));
  }
}
