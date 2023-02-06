<?php

namespace app\modules\repo\components;

use app\models\User;

/**
 *
 */
abstract class UserRepos
{
    protected RepoDTOArray $repoDTOArray;
    protected array $reposInfo;

    /**
     * @return void
     */
    abstract protected function prepareDTORepos(): void;

    /**
     * @return mixed
     */
    public function getRepos(User $user): RepoDTOArray
    {
        $this->fetchRepos($user);
        $this->prepareDTORepos();

        return $this->repoDTOArray;
    }
}