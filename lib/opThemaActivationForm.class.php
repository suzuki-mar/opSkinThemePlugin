<?php

class opThemaActivationForm extends sfForm
{

  protected
  $pluginFieldKey = 'plugin';

  public function configure()
  {
    $plugins = $this->getOption('plugins');

    $choices = array();
    $pluginDefault = array();

    foreach ($plugins as $plugin)
    {
      $choices[$plugin->getName()] = $plugin->getName();

      if ($plugin->getIsActive())
      {
        $pluginDefault[] = $plugin->getName();
      }
    }

    $widgetOptions = array(
        'choices' => $choices,
        'multiple' => true,
        'expanded' => true,
        'renderer_options' => array(
            'formatter' => array($this, 'formatter')
        )
    );
    $validatorOptions = array(
        'choices' => array_keys($choices),
        'multiple' => true,
        'required' => false,
    );
    $validatorMessages = array();

    $widgetOptions['multiple'] = false;
    $validatorOptions['multiple'] = false;
    $validatorOptions['required'] = true;
    $validatorMessages['required'] = 'You must activate only a skin plugin.';

    if (is_array($pluginDefault))
    {
      //$pluginDefault = $pluginDefault[0];
    }

    $this->setWidget($this->pluginFieldKey, new sfWidgetFormChoice($widgetOptions));
    $this->setValidator($this->pluginFieldKey, new sfValidatorChoice($validatorOptions, $validatorMessages));
    $this->setDefault($this->pluginFieldKey, $pluginDefault);

    $this->widgetSchema->setNameFormat('plugin_activation[%s]');
  }

  public function formatter($widget, $inputs)
  {
    $plugins = $this->getOption('plugins');
    $prefix = $widget->generateId(sprintf($this->widgetSchema->getNameFormat(), $this->pluginFieldKey)) . '_';
    $rows = array();
    foreach ($inputs as $id => $input)
    {
      $name = substr($id, strlen($prefix));
      $plugin = $plugins[$name];
      $rows[] = $widget->renderContentTag('tr',
                      $widget->renderContentTag('td', $input['input']) .
                      $widget->renderContentTag('td', $input['label']) .
                      $widget->renderContentTag('td', sfWidget::escapeOnce($plugin->getVersion())) .
                      $widget->renderContentTag('td', sfWidget::escapeOnce($plugin->getSummary())) .
                      $widget->renderContentTag('td', 'プレビューへのリンク')
      );
    }
    return!$rows ? '' : implode($widget->getOption('separator'), $rows);
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    parent::bind($taintedValues, $taintedFiles);
    if (count($this->errorSchema))
    {
      $newErrorSchema = new sfValidatorErrorSchema($this->validatorSchema);
      foreach ($this->errorSchema as $name => $error)
      {
        if ($this->pluginFieldKey === $name)
        {
          $newErrorSchema->addError($error);
        }
        else
        {
          $newErrorSchema->addError($error, $name);
        }
      }
      $this->errorSchema = $newErrorSchema;
    }
  }

  public function save()
  {
    if (!$this->isValid())
    {
      return false;
    }

    //@todo pluginFieldKeyをthemaKeyみたいな感じに変更する
    $value = $this->values[$this->pluginFieldKey];

    $skinThemaInfo = new opSkinThemaInfo();
    

    return $skinThemaInfo->save($value);
  }

}
