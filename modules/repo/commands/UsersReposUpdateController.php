<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\repo\commands;

use app\modules\repo\components\RepoUpdater;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Обновление списка репозиториев пользователей
 */
class UsersReposUpdateController extends Controller
{
    /**
     *
     * @return int Exit code
     */
    public function actionRun(): int
    {
        $query = User::find();

        foreach ($query->each() as $user) {
            /** @var User $user */
            $githubSync = RepoUpdater::getUpdater($user->type);
            $githubSync->update($user);
        }

        return ExitCode::OK;
    }
}
