<?php

// use App\Models\User;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text("comment");
            $table->integer("up_vote")->default(0);
            $table->integer("down_vote")->default(0);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Post::class);
            $table->foreignIdFor(Comment::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
