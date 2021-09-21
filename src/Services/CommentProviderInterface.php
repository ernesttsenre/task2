<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Services;

use Ernesttsenre\CommentService\Dto\Comment;

interface CommentProviderInterface
{
    /**
     * @return Comment[]
     */
    public function get(): array;
    public function create(Comment $comment): Comment;
    public function update(Comment $comment): Comment;
}
