<?php

namespace App\Command;

use App\Service\DeleteTaskService;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteTaskCommand extends Command
{
    private DeleteTaskService $deleteTask;
    protected static $defaultName = 'task:delete';

    public function __construct(DeleteTaskService $deleteTask)
    {
        parent::__construct();
        $this->deleteTask = $deleteTask;
    }

    protected function configure()
    {
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->deleteTask->deleteTaskAuto();

        return Command::SUCCESS;
    }
}
