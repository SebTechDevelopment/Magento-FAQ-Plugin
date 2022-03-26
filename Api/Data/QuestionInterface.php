<?php

namespace SebTech\FAQTwo\Api\Data;

interface QuestionInterface
{
    public function getId();

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function getAnswer(): string;

    public function setAnswer(string $answer): void;

    public function setEnabled(bool $enabled): void;

    public function getEnabled(): bool;

}
