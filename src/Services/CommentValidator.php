<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Services;

class CommentValidator
{
    public function isValid(array $data): bool
    {
        if (!isset($data['id']) || !is_int($data['id'])) {
            return false;
        }

        if (!isset($data['name'])) {
            return false;
        }

        if (!isset($data['text'])) {
            return false;
        }

        return true;
    }
}
