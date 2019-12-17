<?php

namespace Platform\AuthorBundle\Model\Interfaces;


interface SketchInterface
{

    public function getId(): int;

    public function getName(): string;

    public function getThumbnail(): ?string;

    public function getState(): int;

    public function getCreatedAt(): \DateTime;

    public function getUpdatedAt(): \DateTime;
}
