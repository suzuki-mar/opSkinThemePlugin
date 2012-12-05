<?php

class opThemeActivationForm extends sfForm
{

  protected
  $themeFieldKey = 'theme';

  public function configure()
  {
    $themes = $this->getOption('themes');

    $choices = array();

    foreach ($themes as $theme)
    {
      $choices[$theme->getName()] = $theme->getName();
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
    $validatorMessages['required'] = 'You must activate only a skin theme.';

    $this->setWidget($this->themeFieldKey, new sfWidgetFormChoice($widgetOptions));
    $this->setValidator($this->themeFieldKey, new sfValidatorChoice($validatorOptions, $validatorMessages));
    
    $ThemeInfo = new opThemeInfo();
    $this->setDefault($this->themeFieldKey, $ThemeInfo->findUseTehama());

    $this->widgetSchema->setNameFormat('theme_activation[%s]');
  }

  public function formatter($widget, $inputs)
  {
    $themes = $this->getOption('themes');
    $prefix = $widget->generateId(sprintf($this->widgetSchema->getNameFormat(), $this->themeFieldKey)) . '_';
    $rows = array();
    foreach ($inputs as $id => $input)
    {
      $name = substr($id, strlen($prefix));
      $theme = $themes[$name];

      //@todo 国際対応する
      $linkUrl = '/pc_frontend_dev.php/skinpreview/index/theme_name/'.$theme->getName();
      $linkTag = '<a href="'.$linkUrl.'">プレビュー</a>';

      $tagIds = array(
        'version' => 'version_'.$theme->getName(),
        'summery' => 'summery_'.$theme->getName(),
      );

      $rows[] = $widget->renderContentTag('tr',
                      $widget->renderContentTag('td', $input['input']) .
                      $widget->renderContentTag('td', $input['label']) .
                      $widget->renderContentTag('td', sfWidget::escapeOnce($theme->getVersion()), array('id' => $tagIds['version'])) .
                      $widget->renderContentTag('td', sfWidget::escapeOnce($theme->getSummary()), array('id' => $tagIds['summery'])) .
                      $widget->renderContentTag('td', $linkTag)
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
        if ($this->themeFieldKey === $name)
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

    //@todo themeFieldKeyをThemeKeyみたいな感じに変更する
    $value = $this->values[$this->themeFieldKey];

    $skinThemeInfo = new opThemeInfo();
    

    return $skinThemeInfo->save($value);
  }

}
