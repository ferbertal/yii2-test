<?php

namespace app\modules\repo\components\update;

use app\modules\repo\components\RepoUpdater;
use app\modules\repo\components\user\GithubUserRepos;

/**
 */
class GithubRepoUpdater extends RepoUpdater
{
    /**
     * @return GithubUserRepos
     */
    public function getUserRepos(): GithubUserRepos
    {
        return new GithubUserRepos();
    }
}