<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Issue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $sprint = $this->getDoctrine()
            ->getRepository('AppBundle:Sprint')
            ->find($id);

        if ('CLOSE' === $sprint->getStatus()) {
            $this->get('session')->getFlashBag()->add('error', 'Sprint already closed');

            return $this->redirect($this->generateUrl('show_sprint', array('id' => $id)));
        }

        $totalIssuesCount = $sprint->getIssues()->count();
        /** @var Issue $issue */
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

        $this->getDoctrine()->getManager()->flush();

        $closedIssueCount = $sprint->getIssues()->count();

        return new JsonResponse(
            array(
                'totalIssuesCount'  => $totalIssuesCount,
                'closedIssuesCount' => $closedIssueCount
            )
        );
    }

    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        return $this->render('AppBundle:Sprint:show.html.twig', array('id' => $id));
    }
}