<?php

namespace app\modules\repo\components;

/**
 *
 */
class RepoDTO
{
    public $name;
    public $updatedAt;

    public function __construct($name, $updatedAt)
    {
        $this->name = $name;
        $this->updatedAt = $updatedAt;
    }
}