<?php

namespace Platform\AuthorBundle\Model;


use JMS\Serializer\Annotation as JMS;
use Platform\AuthorBundle\Entity\Sketch\{SketchCourse, SketchExam};
use Platform\AuthorBundle\Model\Interfaces\SketchInterface;

class PublicationModel
{
    /**
     * @var SketchInterface
     * @JMS\Exclude()
     */
    private $publication;
    /**
     * @var string|null
     * @JMS\Exclude()
     */
    private $resourcePath;

    public function __construct(SketchInterface $publication, ?string $resourcePath)
    {
        $this->publication = $publication;
        $this->resourcePath = $resourcePath;
    }

    /**
     * @JMS\VirtualProperty()
     * @return int
     */
    public function getId(): int
    {
        return $this->publication->getId();
    }

    /**
     * @JMS\VirtualProperty()
     * @return string
     */
    public function getName(): string
    {
        return $this->publication->getName();
    }

    /**
     * @JMS\VirtualProperty()
     * @return null|string
     */
    public function getThumbnail(): ?string
    {
        return $this->resourcePath;
    }

    /**
     * @JMS\VirtualProperty()
     * @return int
     */
    public function getState(): int
    {
        return $this->publication->getState();
    }

    /**
     * @JMS\VirtualProperty()
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->publication->getCreatedAt();
    }

    /**
     * @JMS\VirtualProperty()
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->publication->getUpdatedAt();
    }

    /**
     * @JMS\VirtualProperty()
     * @return string
     */
    public function getType(): string
    {
        if ($this->publication instanceof SketchCourse)
            return "course";
        elseif ($this->publication instanceof SketchExam)
            return "exam";
        else
            return null;
    }
}
