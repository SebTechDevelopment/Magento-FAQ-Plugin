<?php

namespace SebTech\FAQTwo\Api\Data;

interface CategoryInterface
{
    public function getId();

    public function getTitle();

    public function setTitle(string $title): void;

    public function setEnabled(bool $enabled): void;

    public function getEnabled(): bool;

}
