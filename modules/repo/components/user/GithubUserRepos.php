<?php

namespace app\modules\repo\components\user;

use app\modules\repo\components\RepoDTO;
use app\modules\repo\components\RepoDTOArray;
use app\models\User;
use app\modules\repo\components\UserRepos;
use Github\Client;

/**
 *
 */
class GithubUserRepos extends UserRepos
{
    private Client $client;

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
        $reposInfo = $this->client->api('user')
            ->repositories($user->name, 'owner', 'full_name', 'desc');

        $this->reposInfo = $reposInfo;
    }

    /**
     * @return void
     */
    protected function prepareDTORepos(): void
    {
        $repoDTOArray = new RepoDTOArray();
        foreach ($this->reposInfo as $repoInfo) {
            $repoDTOArray[] = new RepoDTO(
                $repoInfo['name'],
                $repoInfo['updated_at']
            );
        }

        $this->repoDTOArray = $repoDTOArray;
    }
}