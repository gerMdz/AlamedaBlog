<?php

namespace App\Form\Models;

class FileUploadModel
{
    private ?string $imageFilename;

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;
        return $this;
    }



}