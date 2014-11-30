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
     * @var string
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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getEffectiveClosedAt()
    {
        return $this->effectiveClosedAt;
    }

    public function setEffectiveClosedAt(\DateTime $effectiveClosedAt)
    {
        $this->effectiveClosedAt = $effectiveClosedAt;
    }

    /**
     * @return \DateTime
     */
    public function getExpectedClosedAt()
    {
        return $this->expectedClosedAt;
    }

    public function setExpectedClosedAt(\DateTime $expectedClosedAt)
    {
        $this->expectedClosedAt = $expectedClosedAt;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function addIssue(Issue $issues)
    {
        $this->issues[] = $issues;
    }

    public function removeIssue(Issue $issues)
    {
        $this->issues->removeElement($issues);
    }

    /**
     * @return Collection
     */
    public function getIssues()
    {
        return $this->issues;
    }
}
