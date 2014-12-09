<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sprint;
use AppBundle\Repository\SprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SprintController extends Controller
{
    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function closeAction($id)
    {
        /** @var SprintRepository $sprintRepository */
        $sprintRepository = $this->getDoctrine()->getRepository('AppBundle:Sprint');

        /** @var Sprint $sprint */
        $sprint = $sprintRepository->find($id);

        if (null === $sprint) {
            throw new NotFoundHttpException();
        }

        if ('CLOSE' === $sprint->getStatus()) {
            $this->get('session')->getFlashBag()->add('error', 'Sprint already closed');

            return $this->redirect($this->generateUrl('show_sprint', array('id' => $id)));
        }

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

        $closedIssueCount = $sprint->getIssues()->count();
        $averageClosedIssues = $sprintRepository->findAverageClosedIssues();

        $this->getDoctrine()->getManager()->flush();

        return $this->render(
            'AppBundle:Sprint:close.html.twig',
            array('id' => $id, 'closedIssuesCount' => $closedIssueCount, 'averageClosedIssues' => $averageClosedIssues)
        );
    }

    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $sprint = $this->getDoctrine('service.sprint')->getRepository('AppBundle:Sprint')->find($id);
        if (null === $sprint) {
            throw new NotFoundHttpException();
        }

        return $this->render('AppBundle:Sprint:show.html.twig', array('sprint' => $sprint));

    }
}
