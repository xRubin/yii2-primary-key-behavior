<?php

namespace rubin\Yii2PrimaryKeyBehavior;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class PrimaryKeyBehavior extends AttributeBehavior
{
    /** @var  string */
    public $attribute = 'id';
    
    /** @var KeyGeneratorInterface */
    public $generator;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->attribute,
            ];
        }
    }

    /**
     * @param \yii\base\Event $event
     * @return mixed
     */
    protected function getValue($event)
    {
        if (null === $this->value) {
            return $this->generator->getNextId();
        }

        return parent::getValue($event);
    }
}
