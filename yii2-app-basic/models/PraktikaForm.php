<?php

namespace app\models;

use yii\base\Model;

class PraktikaForm extends Model
{
    public $praktika_id;

    public function rules()
    {
        return [
            [['praktika_id'],'required'],
        ];
    }
}

?>