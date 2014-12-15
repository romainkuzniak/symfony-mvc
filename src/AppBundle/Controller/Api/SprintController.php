<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Sprint;
use AppBundle\Repository\SprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            return new JsonResponse('Sprint already closed', 400);
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

        $averageClosedIssues = $sprintRepository->findAverageClosedIssues();
        $closedIssueCount = $sprint->getIssues()->count();

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            array(
                'closedIssuesCount'   => $closedIssueCount,
                'averageClosedIssues' => $averageClosedIssues
            )
        );
    }

    /**
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction($id)
    {
        $sprint = $this->getDoctrine()->getRepository('AppBundle:Sprint')->find($id);

        $response = new JsonResponse();
        $response->setContent($this->get('jms_serializer')->serialize($sprint, 'json'));

        return $response;
    }
}
