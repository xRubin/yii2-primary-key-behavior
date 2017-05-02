<?php

namespace rubin\Yii2PrimaryKeyBehavior\generator;

use Yii;
use yii\base\Component;
use yii\redis\Connection;
use rubin\Yii2PrimaryKeyBehavior\KeyGeneratorInterface;

class RedisSequenceGenerator extends Component implements KeyGeneratorInterface
{
    /** @var string  */
    public $connection = 'redis';

    /** @var string */
    public $key;

    /**
     * Returns the database connection.
     * @return Connection.
     */
    public function getConnection()
    {
        return Yii::$app->get($this->connection);
    }

    /**
     * @return int
     */
    public function getNextId()
    {
        return $this->getConnection()->INCR($this->key);
    }
}