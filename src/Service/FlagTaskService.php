<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 03/06/2022
 * Time: 12:48
 */

namespace App\Service;

use App\Entity\Task;

class FlagTaskService
{
    public function flagTask(Task $task): ?string
    {
        if ($task->getIsDone() == false) {
            return $this->flagIsNotDone($task);
        } elseif ($task->getIsDone() == true) {
            return $this->flagIsDone($task);
        }

        return null;
    }

    private function flagIsDone(Task $task): string
    {
        $task->setIsDone(false);
        return sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle());
    }

    private function flagIsNotDone(Task $task): string
    {
        $task->setIsDone(true);
        return sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle());
    }
}