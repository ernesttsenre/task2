<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Dto;

class Comment
{
    private ?int $id = null;
    private string $name;
    private string $text;

    public function __construct(string $name, string $text, ?int $id = null)
    {
        $this->name = $name;
        $this->text = $text;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function serializeToArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'text' => $this->getText(),
        ];
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }
}
