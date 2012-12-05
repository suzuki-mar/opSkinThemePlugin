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

    $widgetOptions['multiple'] = false;
    $this->setWidget($this->themeFieldKey, new sfWidgetFormChoice($widgetOptions));

    $validatorOptions = array(
        'choices' => array_keys($choices),
        'multiple' => true,
        'required' => false,
    );

    $validatorOptions['multiple'] = false;
    $validatorOptions['required'] = true;

    $validatorMessages = array();
    $validatorMessages['required'] = 'You must activate only a skin theme.';

    $this->setValidator($this->themeFieldKey, new sfValidatorChoice($validatorOptions, $validatorMessages));

    $themeInfo = new opThemeConfig();

    if ($themeInfo->registeredUsedTheme())
    {
      $default = $themeInfo->findUseTheme();
      
    }
    else
    {
      if (!empty($choices))
      {
        $default = array_shift($choices);
      }
      else
      {
        $default = null;
      }
    }

    $this->setDefault($this->themeFieldKey, $default);

    $this->widgetSchema->setNameFormat('theme_activation[%s]');
  }

  public function formatter($widget, $inputs)
  {
    if (empty($inputs))
    {
      return '';
    }

    $themes = $this->getOption('themes');
    $prefix = $widget->generateId(sprintf($this->widgetSchema->getNameFormat(), $this->themeFieldKey)).'_';

    $rows = array();
    foreach ($inputs as $id => $input)
    {
      $name = substr($id, strlen($prefix));
      $theme = $themes[$name];

      $rows[] = $this->createRowTag($widget, $input, $theme);
    }

    $rowString = implode($widget->getOption('separator'), $rows);

    return $rowString;
  }

  private function createRowTag($widget, $input, $theme)
  {
    //@todo 国際対応する
    $linkUrl = '/pc_frontend_dev.php/skinpreview/index/theme_name/'.$theme->getName();
    $linkTag = '<a href="'.$linkUrl.'">プレビュー</a>';

    $tagIds = array(
        'version' => 'version_'.$theme->getName(),
        'summery' => 'summery_'.$theme->getName(),
    );

    $rowContentTag =
            $widget->renderContentTag('td', $input['input']).
            $widget->renderContentTag('td', $input['label']).
            $widget->renderContentTag('td', sfWidget::escapeOnce($theme->getVersion()), array('id' => $tagIds['version'])).
            $widget->renderContentTag('td', sfWidget::escapeOnce($theme->getSummary()), array('id' => $tagIds['summery'])).
            $widget->renderContentTag('td', $linkTag);

    return $widget->renderContentTag('tr', $rowContentTag);
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

    $value = $this->values[$this->themeFieldKey];

    $skinThemeInfo = new opThemeConfig();

    return $skinThemeInfo->save($value);
  }

}
