<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Tests;

use Ernesttsenre\CommentService\Dto\Comment;
use Ernesttsenre\CommentService\Exceptions\InvalidCommentException;
use Ernesttsenre\CommentService\Services\CommentFactory;
use Ernesttsenre\CommentService\Services\CommentValidator;
use PHPUnit\Framework\TestCase;

class CommentFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $commentFactory = $this->getCommentFactory();

        $expectedComment = ['id' => 1, 'name' => 'name', 'text' => 'text'];

        $comment = $commentFactory->create($expectedComment);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($expectedComment, [
            'id' => $comment->getId(),
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ]);
    }

    public function testCreateInvalidCommentException(): void
    {
        $this->expectException(InvalidCommentException::class);

        $commentFactory = $this->getCommentFactory();

        $invalidComment = ['someWrongField' => 'wrong', 'text' => 'text'];

        $commentFactory->create($invalidComment);
    }

    private function getCommentFactory(): CommentFactory
    {
        return new CommentFactory(new CommentValidator());
    }
}
