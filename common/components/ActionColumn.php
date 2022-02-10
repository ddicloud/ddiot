<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 10:07:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-23 09:49:51
 */

namespace common\components;

use diandi\admin\components\Helper;
use Yii;
use yii\bootstrap\ButtonGroup;
use yii\helpers\Html;

//公共方法类库

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = '{view} {update} {delete}';

    public $urls = [];
    
    public $contentOptions = [
        'class'=>'btn-group',
        'style'=>[
            'width'=>'100%'
        ]
    ];

    /**
     * Initializes the default button rendering callback for single button.
     *
     * @param string $name              Button name as it's written in template
     * @param string $iconName          The part of Bootstrap glyphicon class that makes it unique
     * @param array  $additionalOptions Array of additional options
     *
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        $template = Helper::filterActionColumn($this->template);
        if (!isset($this->buttons[$name]) && strpos($template, '{'.$name.'}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                
                $color_style = 'btn-primary';
                
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $color_style = 'btn-danger';
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    // 'class' => 'btn btn-default btn-ac',
                    'class' => 'btn '. $color_style,
                ], $additionalOptions, $this->buttonOptions);
                
                

                $icon = Html::tag('span','', ['class' => " glyphicon glyphicon-$iconName"]);
                $title_str = Html::tag('span',$title, ['class' => "padding-left-xs"]);

                $urls = $this->urls;
                if ($urls) {
                    foreach ($urls as $k => $val) {
                        $urll[$k] = $model[$val];
                    }
                    $urlsStr = http_build_query($urll);
                    $url = $url.'&'.$urlsStr;
                } 


                return Html::a($icon.$title_str, $url,$options);
            };
            
         
        }
    }
}
