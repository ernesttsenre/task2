<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Tests;

use Ernesttsenre\CommentService\Services\CommentValidator;
use PHPUnit\Framework\TestCase;

class CommentValidatorTest extends TestCase
{
    /**
     * @dataProvider getCommentsProvider
     */
    public function testCreate(bool $expected, array $data): void
    {
        $commentValidator = new CommentValidator();

        $this->assertEquals($expected, $commentValidator->isValid($data));
    }

    public function getCommentsProvider(): array
    {
        return [
            [
                'expected' => true,
                'data' => [
                    'id' => 1,
                    'name' => 'name',
                    'text' => 'text',
                ]
            ],
            [
                'expected' => false,
                'data' => [
                    'name' => 'name',
                    'text' => 'text',
                ]
            ],
            [
                'expected' => false,
                'data' => [
                    'id' => 'some text id',
                    'name' => 'name',
                    'text' => 'text',
                ]
            ],
            [
                'expected' => false,
                'data' => [
                    'id' => 1,
                    'text' => 'text',
                ]
            ],
            [
                'expected' => false,
                'data' => [
                    'id' => 1,
                    'name' => 'name',
                ]
            ],
        ];
    }
}
