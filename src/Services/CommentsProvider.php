<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Services;

use Ernesttsenre\CommentService\Components\ApiClient;
use Ernesttsenre\CommentService\Dto\Comment;
use InvalidArgumentException;

final class CommentsProvider implements CommentProviderInterface
{
    private ApiClient $apiClient;
    private CommentFactory $commentFactory;

    public function __construct(ApiClient $apiClient, CommentFactory $commentFactory)
    {
        $this->apiClient = $apiClient;
        $this->commentFactory = $commentFactory;
    }

    /**
     * @return Comment[]
     */
    public function get(): array
    {
        return array_map(
            fn ($data) => $this->commentFactory->create($data),
            $this->apiClient->get('comments')
        );
    }

    public function create(Comment $comment): Comment
    {
        if (!$comment->isNew()) {
            throw new InvalidArgumentException('Comment already exists');
        }

        $data = $this->apiClient->post('comment', [
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ]);

        return $this->commentFactory->create($data);
    }

    public function update(Comment $comment): Comment
    {
        if ($comment->isNew()) {
            throw new InvalidArgumentException('Comment must have id');
        }

        $data = $this->apiClient->put("comment/{$comment->getId()}", [
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ]);

        return $this->commentFactory->create($data);
    }
}
