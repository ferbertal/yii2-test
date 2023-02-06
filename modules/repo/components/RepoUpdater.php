<?php

namespace app\modules\repo\components;

use app\models\Repo;
use app\models\User;
use app\modules\repo\components\update\GithubRepoUpdater;
use app\modules\repo\components\update\GitlabRepoUpdater;

/**
 */
abstract class RepoUpdater
{
    abstract public function getUserRepos(): UserRepos;

    /**
     * @param User $user
     * @return void
     */
    public function update(User $user): void
    {
        $userRepos = $this->getUserRepos();
        $repoDTOArray = $userRepos->getRepos($user);

        foreach ($repoDTOArray as $repoDTO) {
            $repo = (new Repo());
            $repo->setAttributes($repoDTO);
            $repo->save();
        }
    }

    /**
     * @param $type
     * @return RepoUpdater
     */
    public static function getUpdater($type): RepoUpdater
    {
        return match ($type) {
            User::TYPE_GITLAB => new GitlabRepoUpdater(),
            default => new GithubRepoUpdater(),
        };
    }
}