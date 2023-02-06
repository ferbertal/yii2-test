<?php

namespace app\modules\repo\components\update;

use app\modules\repo\components\RepoUpdater;
use app\modules\repo\components\user\GitlabUserRepos;

/**
 */
class GitlabRepoUpdater extends RepoUpdater
{
    /**
     * @return GitlabUserRepos
     */
    public function getUserRepos(): GitlabUserRepos
    {
        return new GitlabUserRepos();
    }
}