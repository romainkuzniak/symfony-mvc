<?php

namespace AppBundle\Command;

use AppBundle\Entity\Sprint;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CloseSprintCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('agility-board:close-sprint')
            ->setDescription('Close sprint');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $sprint = $this->getContainer()->get('doctrine')
                ->getRepository('AppBundle:Sprint')
                ->findSprintToClose();

            $totalIssuesCount = $sprint->getIssues()->count();

            foreach ($sprint->getIssues() as $issue) {
                if ('DONE' === $issue->getStatus()) {
                    $issue->setClosedAt(new \DateTime());
                    $issue->setStatus('CLOSE');
                } else {
                    $sprint->removeIssue($issue);
                }
            }
            $sprint->setEffectiveClosedAt(new \DateTime());
            $sprint->setStatus('CLOSE');

            $this->getContainer()->get('doctrine')->getManager()->flush();

            $closedIssueCount = $sprint->getIssues()->count();

            $output->writeln('Close Sprint');
            $output->writeln('id: ' . $sprint->getId());
            $output->writeln('totalIssuesCount: ' . $totalIssuesCount);
            $output->writeln('closedIssuesCount: ' . $closedIssueCount);
        } catch (NoResultException $nre) {
            $output->writeln('None');
        }
    }
}
