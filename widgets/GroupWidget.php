<?php

namespace app\widgets;
use app\models\GroupTask;
use yii\base\Widget;

class GroupWidget extends Widget{

    public $template = 'group.php';
    public $data;
    public $tree;
    public $groupHtml;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->data = GroupTask::find()->indexBy('id')->asArray()->where(['user_id' => \Yii::$app->user->id])->all();
//        $this->data = GroupTask::find()->indexBy('id')->asArray()->all();
        $this->groupHtml = $this->getGroupHtml();
//        echo '<pre>'.print_r($this->data).'</pre>';
        return $this->groupHtml;
    }

    protected function getGroupHtml(){
        $str = '';
        foreach ($this->data as $group){
            $str .= $this->catToTemplate($group);
        }
        return $str;
    }

    protected function catToTemplate($group){
        ob_start();
        include __DIR__ . '/template/' . $this->template;
        return ob_get_clean();
    }
}