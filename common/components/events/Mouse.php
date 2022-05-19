<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-19 21:30:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-19 21:47:39
 */
namespace common\components\events;


use yii\base\Component;

class Mouse extends Component
{
    const EVEN_MOUSE_RUN = 'run';
    
    public function run($event)
    {

        if ($event->data) {
            echo $event->data . PHP_EOL;
        }
        echo "i am mouse, running now !".PHP_EOL;
        $this->trigger(self::EVEN_MOUSE_RUN);
    }

    public function cry($event)
    {
        echo $event->data . PHP_EOL;
        echo 'i am crying!'.PHP_EOL;
        $doself = new static(); // new self();
        $doself->trigger(self::EVEN_MOUSE_RUN);
    }

    public function ex1($event)
    {
        echo '再次触发'.$event->data . PHP_EOL;
        // var_dump($event);
    }


    public function ex2($event)
    {
        $event->handled = true;
        echo $event->data . PHP_EOL;

        var_dump($event);
    }

    public function ex3($event)
    {
        echo $event->data . PHP_EOL;
    }

    public function ex5($event)
    {
        echo $event->data . PHP_EOL;
        $event->handled = true ;
    }
}