<?php

namespace app\modules\repo\components\user;

use app\modules\repo\components\RepoDTOArray;
use app\models\User;
use app\modules\repo\components\UserRepos;
use Github\Client;

/**
 *
 */
class GitlabUserRepos extends UserRepos
{
    private $client;

    /**
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param User $user
     * @return void
     */
    protected function fetchRepos(User $user): void
    {
        $reposInfo = [];

        $this->reposInfo = $reposInfo;
    }

    /**
     * @return void
     */
    protected function prepareDTORepos(): void
    {
        $repoDTOArray = new RepoDTOArray();

        $this->repoDTOArray = $repoDTOArray;
    }
}