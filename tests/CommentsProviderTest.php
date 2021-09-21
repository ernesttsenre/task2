<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Tests;

use Ernesttsenre\CommentService\Components\ApiClient;
use Ernesttsenre\CommentService\Dto\Comment;
use Ernesttsenre\CommentService\Exceptions\InvalidCommentException;
use Ernesttsenre\CommentService\Services\CommentFactory;
use Ernesttsenre\CommentService\Services\CommentsProvider;
use Ernesttsenre\CommentService\Services\CommentValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class CommentsProviderTest extends TestCase
{
    private MockHandler $mockHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = new MockHandler();
    }

    public function testGet(): void
    {
        $expectedComments = [
            ['id' => 1, 'name' => 'name 1', 'text' => 'text 1'],
            ['id' => 2, 'name' => 'name 2', 'text' => 'text 2']
        ];
        $expectedResponse = $this->getJsonResponse(200, $expectedComments);

        $this->mockHandler->append($expectedResponse);

        $provider = $this->getCommentProvider();
        $comments = $provider->get();

        $this->assertCount(2, $comments);

        $actualComments = array_map(fn (Comment $comment) => [
            'id' => $comment->getId(),
            'name' => $comment->getName(),
            'text' => $comment->getText()
        ], $comments);

        $this->assertEquals($expectedComments, $actualComments);
    }

    public function testGetInvalidCommentException(): void
    {
        $this->expectException(InvalidCommentException::class);

        $invalidResponse = $this->getJsonResponse(200, [
            ['name' => 'name 1', 'text' => 'text 1'],
            ['id' => 2, 'text' => 'text 2']
        ]);

        $this->mockHandler->append($invalidResponse);

        $provider = $this->getCommentProvider();
        $provider->get();
    }

    public function testCreate(): void
    {
        $expectedComment = ['id' => 1, 'name' => 'name', 'text' => 'text'];
        $expectedResponse = $this->getJsonResponse(201, $expectedComment);

        $this->mockHandler->append($expectedResponse);

        $provider = $this->getCommentProvider();
        $comment = $provider->create(new Comment('name', 'text'));

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($expectedComment, [
            'id' => $comment->getId(),
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ]);
    }

    public function testCreateInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $provider = $this->getCommentProvider();
        $provider->create(new Comment('name', 'text', 1));
    }

    public function testCreateInvalidCommentException(): void
    {
        $this->expectException(InvalidCommentException::class);

        $invalidComment = ['someField' => 'name'];
        $invalidResponse = $this->getJsonResponse(200, $invalidComment);

        $this->mockHandler->append($invalidResponse);

        $provider = $this->getCommentProvider();
        $provider->create(new Comment('name', 'text'));
    }

    public function testUpdate(): void
    {
        $expectedComment = ['id' => 1, 'name' => 'name updated', 'text' => 'text updated'];
        $expectedResponse = $this->getJsonResponse(200, $expectedComment);

        $this->mockHandler->append($expectedResponse);

        $provider = $this->getCommentProvider();
        $comment = $provider->update(new Comment('name updated', 'text updated', 1));

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($expectedComment, [
            'id' => $comment->getId(),
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ]);
    }

    public function testUpdateException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $provider = $this->getCommentProvider();
        $provider->update(new Comment('name', 'text'));
    }

    public function testUpdateInvalidCommentException(): void
    {
        $this->expectException(InvalidCommentException::class);

        $invalidComment = ['someField' => 'name'];
        $invalidResponse = $this->getJsonResponse(200, $invalidComment);

        $this->mockHandler->append($invalidResponse);

        $provider = $this->getCommentProvider();
        $provider->update(new Comment('name', 'text', 1));
    }

    private function getCommentProvider(): CommentsProvider
    {
        $handlerStack = HandlerStack::create($this->mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $apiClient = new ApiClient($client);
        $commentValidator = new CommentValidator();
        $commentFactory = new CommentFactory($commentValidator);

        return new CommentsProvider($apiClient, $commentFactory);
    }

    private function getJsonResponse(int $statusCode, array $data): Response
    {
        return new Response(
            $statusCode,
            ['Content-Type' => 'application/json'],
            Utils::streamFor(json_encode($data))
        );
    }
}
