<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    // comment test
    public function testCreateComment()
    {
        $comment = new Comment(); // ambil model comment
        $comment->email = "abil@pzn.com"; // isi data email
        $comment->title = "Sample Title"; // isi data title
        $comment->comment = "Sample Comment"; // isi data comment
        // $comment->commentable_id = '1';
        // $comment->commentable_type = 'product';

        $comment->save(); // simpan datanya

        self::assertNotNull($comment->id); // hasilnya kolom id tida boleh kosong
    }

    // public function testDefaultAttributeValues()
    // {
    //     $comment = new Comment();
    //     $comment->email = "eko@pzn.com";
    //     $comment->commentable_id = '1';
    //     $comment->commentable_type = 'product';

    //     $comment->save();

    //     self::assertNotNull($comment->id);
    //     self::assertNotNull($comment->title);
    //     self::assertNotNull($comment->comment);
    // }
}
