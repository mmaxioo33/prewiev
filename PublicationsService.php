<?php

namespace Platform\AuthorBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Platform\AuthorBundle\Entity\{Author, AuthorProduct, Sketch\SketchCourse, Sketch\SketchExam};
use Platform\AuthorBundle\Service\Builder\PublicationModelBuilder;

class PublicationsService
{
    /** @var EntityManagerInterface $em */
    private $em;
    /** @var PublicationModelBuilder $publicationModelBuilder */
    private $publicationModelBuilder;

    public function __construct(EntityManagerInterface $em, PublicationModelBuilder $publicationModelBuilder)
    {
        $this->em = $em;
        $this->publicationModelBuilder = $publicationModelBuilder;
    }

    /**
     * @param Author $author
     * @return array
     */
    public function getAuthorPublications(Author $author): array
    {
        $courseSketches = $this->getAuthorSketches($author, AuthorProduct::COURSE);
        $examSketches = $this->getAuthorSketches($author, AuthorProduct::EXAM);

        $coursePublications = $this->publicationModelBuilder->buildArray($courseSketches);
        $examPublications = $this->publicationModelBuilder->buildArray($examSketches);

        return array_merge($coursePublications, $examPublications);
    }

    /**
     * @param Author $author
     * @param string $productType
     * @return array|null
     */
    public function getAuthorSketches(Author $author, string $productType): ?array
    {
        $sketchesArray = array();
        $sketchesIds = $this->em->getRepository(AuthorProduct::class)->getSketches($author, $productType);

        if (!$sketchesIds)
            return [];

        if ($productType == AuthorProduct::COURSE) {
            foreach ($sketchesIds as $sketchId) {
                $sketch = $this->em->getRepository(SketchCourse::class)->findOneBy(['id' => $sketchId]);
                array_push($sketchesArray, $sketch);
            }
        }
        elseif ($productType == AuthorProduct::EXAM) {
            foreach ($sketchesIds as $sketchId) {
                $sketch = $this->em->getRepository(SketchExam::class)->findOneBy(['id' => $sketchId]);
                array_push($sketchesArray, $sketch);
            }
        }
        return $sketchesArray;
    }
}
