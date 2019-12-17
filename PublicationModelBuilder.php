<?php

namespace Platform\AuthorBundle\Service\Builder;


use Platform\AuthorBundle\Model\{Interfaces\SketchInterface, PublicationModel};
use Platform\SupportBundle\Service\S3FileUploader;

class PublicationModelBuilder
{
    private $fileUploader;

    public function __construct(S3FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param SketchInterface $publication
     * @return PublicationModel
     */
    public function build(SketchInterface $publication): PublicationModel
    {
        $resourcePath = $this->fileUploader->generatePublicResourceLink($publication->getThumbnail());

        return new PublicationModel($publication, $resourcePath);
    }

    /**
     * @param $publications SketchInterface[]
     * @return PublicationModel[]
     */
    public function buildArray(array $publications): array
    {
        return array_map(function (SketchInterface $publication) {
            return $this->build($publication);
        }, $publications);
    }
}
