<?php

namespace Ql\Module\Qltextsforusers\Site;
class Text
{

    private ?string $label;
    private ?string $text;
    private ?int $userGroupId;
    private ?int $userGroupSelect;

    public function __construct(?string $text, ?string $label = null)
    {
        $this->setText($text);
        $this->setLabel($label);
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): Text
    {
        if (empty($label) || empty(strip_tags($label))) {
            $label = null;
        }
        $this->label = $label;
        return $this;
    }

    public function issetText(): bool
    {
        return !empty($this->text);
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): Text
    {
        if (empty($text) || empty(strip_tags($text))) {
            $text = null;
        }
        $this->text = $text;
        return $this;
    }

    public function getUserGroupId(): ?int
    {
        return $this->userGroupId;
    }

    public function setUserGroupId(?int $userGroupId): Text
    {
        $this->userGroupId = $userGroupId;
        return $this;
    }

    public function getUserGroupSelect(): ?int
    {
        return $this->userGroupSelect;
    }

    public function setUserGroupSelect(?int $userGroupSelect): Text
    {
        $this->userGroupSelect = $userGroupSelect;
        return $this;
    }
}
