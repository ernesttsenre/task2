<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Services;

use Ernesttsenre\CommentService\Dto\Comment;
use Ernesttsenre\CommentService\Exceptions\InvalidCommentException;

class CommentFactory
{
    private CommentValidator $commentValidator;

    public function __construct(CommentValidator $commentValidator)
    {
        $this->commentValidator = $commentValidator;
    }

    public function create(array $data): Comment
    {
        if (!$this->commentValidator->isValid($data)) {
            throw new InvalidCommentException();
        }

        return new Comment($data['name'], $data['text'], $data['id']);
    }
}
