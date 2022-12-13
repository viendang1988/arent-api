<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

class BaseEntity
{
    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function updatedTimestamps()
    {
        $dateTimeNow = new DateTimeImmutable();

        if (method_exists($this, 'setUpdatedAt')) {
            $this->setUpdatedAt($dateTimeNow);
        }
        if (
            method_exists($this, 'getCreatedAt') &&
            method_exists($this, 'setCreatedAt') &&
            $this->getCreatedAt() === null
        ) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

}
