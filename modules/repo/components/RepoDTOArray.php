<?php

namespace app\modules\repo\components;

use ArrayObject;

/**
 *
 */
class RepoDTOArray extends ArrayObject
{
    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        if ($value instanceof RepoDTO) {
            parent::offsetSet($key, $value);
        }
        throw new \InvalidArgumentException('Value must be an RepoDTO');
    }
}