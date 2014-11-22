<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Sprint
 */
class Sprint
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $expectedClosedAt;

    /**
     * @var \DateTime
     */
    private $effectiveClosedAt;

    /**
     * @var Collection
     */
    private $issues;

    public function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Issue
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Sprint
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set expectedEndedAt
     *
     * @param \DateTime $expectedEndedAt
     *
     * @return Sprint
     */
    public function setExpectedClosedAt($expectedEndedAt)
    {
        $this->expectedClosedAt = $expectedEndedAt;

        return $this;
    }

    /**
     * Get expectedEndedAt
     *
     * @return \DateTime
     */
    public function getExpectedClosedAt()
    {
        return $this->expectedClosedAt;
    }

    /**
     * Set closedAt
     *
     * @param \DateTime $closedAt
     *
     * @return Sprint
     */
    public function setEffectiveClosedAt($closedAt)
    {
        $this->effectiveClosedAt = $closedAt;

        return $this;
    }

    /**
     * Get closedAt
     *
     * @return \DateTime
     */
    public function getEffectiveClosedAt()
    {
        return $this->effectiveClosedAt;
    }

    /**
     * Add issues
     *
     * @param Issue $issues
     *
     * @return Sprint
     */
    public function addIssue(Issue $issues)
    {
        $this->issues[] = $issues;

        return $this;
    }

    /**
     * Remove issues
     *
     * @param Issue $issues
     */
    public function removeIssue(Issue $issues)
    {
        $this->issues->removeElement($issues);
    }

    /**
     * Get issues
     *
     * @return Collection
     */
    public function getIssues()
    {
        return $this->issues;
    }
}
