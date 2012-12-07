<?php

/**
* This file is part of the OpenPNE package.
* (c) OpenPNE Project (http://www.openpne.jp/)
*
* For the full copyright and license information, please view the LICENSE
* file and the NOTICE file that were distributed with this source code.
*/

/**
* テーマ選択のフォームクラス
*
* @package OpenPNE
* @subpackage theme
* @author suzuki_mar <supasu145@gmail.com>
*/

class opThemeActivationForm extends sfForm
{
  const
  THEME_FILED_KEY = 'theme';

  public function configure()
  {
    $widgetOptions = array(
        'choices' => $this->findSelectThemes(),
        'multiple' => true,
        'expanded' => true,
        'renderer_options' => array(
            'formatter' => array($this, 'formatter')
        )
    );

    $widgetOptions['multiple'] = false;
    $this->setWidget(self::THEME_FILED_KEY, new sfWidgetFormChoice($widgetOptions));

    $validatorOptions = array(
        'choices' => array_keys($this->findSelectThemes()),
        'multiple' => true,
        'required' => false,
    );

    $validatorOptions['multiple'] = false;
    $validatorOptions['required'] = true;

    $validatorMessages = array();
    $validatorMessages['required'] = 'You must activate only a skin theme.';

    $this->setValidator(self::THEME_FILED_KEY, new sfValidatorChoice($validatorOptions, $validatorMessages));

    $this->setDefault(self::THEME_FILED_KEY, $this->findDefaultThemeName());

    $this->widgetSchema->setNameFormat('theme_activation[%s]');
  }

  private function findSelectThemes()
  {
    $themes = $this->getOption('themes');

    $choices = array();

    foreach ($themes as $theme)
    {
      $choices[$theme->getThemeDirName()] = $theme->getThemeDirName();
    }

    return $choices;
  }

  private function findDefaultThemeName()
  {
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

    return $default;
  }

  public function formatter($widget, $inputs)
  {
    if (empty($inputs))
    {
      return '';
    }

    $themes = $this->getOption('themes');
    $prefix = $widget->generateId(sprintf($this->widgetSchema->getNameFormat(), self::THEME_FILED_KEY)).'_';

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

  private function createRowTag($widget, $input, opTheme $theme)
  {
    //@todo 国際対応する
    $linkUrl = '/pc_frontend_dev.php/skinpreview/index/theme_name/'.$theme->getThemeDirName();
    $linkTag = '<a href="'.$linkUrl.'">プレビュー</a>';

    $tagIds = array(
        'author' => 'author_'.$theme->getThemeName(),
        'version' => 'version_'.$theme->getThemeName(),
        'summery' => 'summery_'.$theme->getThemeName(),
    );

    $rowContents = array(
        'button' => $input['input'],
        'name' => $input['label'],
        'author' => '<a href="'.$theme->getThemeURI().'">'.$theme->getAuthor().'</a>',
        'version' => $theme->getVersion(),
        'description' => $theme->getDescription(),
        'link' => $linkTag,
    );

    $rowContentTag = '';

    foreach ($rowContents as $content)
    {
      $rowContentTag .= $widget->renderContentTag('td', $content);
    }

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
        if (self::THEME_FILED_KEY === $name)
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

    $value = $this->values[self::THEME_FILED_KEY];

    $skinThemeInfo = new opThemeConfig();

    return $skinThemeInfo->save($value);
  }

}
