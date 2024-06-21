<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:review',
    description: 'Displays the day or month with the highest number of published reviews',
)]
class ReviewCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('month', null, InputOption::VALUE_NONE, 'Display the month instead of the day');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->entityManager->getRepository(Review::class);
        $maxReviewsPeriod = $repository->findMaxReviewsPeriod($input->getOption('month'));

        if (!$maxReviewsPeriod) :
            $output->writeln('No reviews found');
        else :
            $format = $input->getOption('month') ? 'Y-m' : 'Y-m-d';
            $output->writeln('The ' . ($input->getOption('month') ? 'month' : 'day') . ' with the highest number of published reviews is:');
            $output->writeln($maxReviewsPeriod->format($format));
        endif;

        return Command::SUCCESS;
    }
}
