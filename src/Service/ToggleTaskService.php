<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 03/06/2022
 * Time: 12:48
 */

namespace App\Service;

use App\Entity\Task;

class ToggleTaskService
{
    public function toggleTask(Task $task): ?string
    {
        if ($task->getIsDone() === false) {
            return $this->toggleIsNotDone($task);
        } elseif ($task->getIsDone() === true) {
            return $this->toggleIsDone($task);
        }

        return null;
    }

    private function toggleIsDone(Task $task): string
    {
        $task->setIsDone(false);
        return sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle());
    }

    private function toggleIsNotDone(Task $task): string
    {
        $task->setIsDone(true);
        return sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle());
    }
}
