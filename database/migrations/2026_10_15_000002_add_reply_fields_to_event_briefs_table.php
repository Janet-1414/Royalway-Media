<?php

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
        Schema::table('event_briefs', function (Blueprint $table) {
            // Add email column only if it doesn't exist
            if (!Schema::hasColumn('event_briefs', 'email')) {
                $table->string('email')->nullable()->after('key_contact');
            }

            $table->string('reply_subject')->nullable()->after('status');
            $table->text('reply_message')->nullable()->after('reply_subject');
            $table->timestamp('replied_at')->nullable()->after('reply_message');
            $table->unsignedBigInteger('replied_by')->nullable()->after('replied_at');
            $table->index('replied_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_briefs', function (Blueprint $table) {
            $table->dropIndex(['replied_by']);
            $table->dropColumn(['reply_subject', 'reply_message', 'replied_at', 'replied_by']);

            // Only drop email if we added it
            if (Schema::hasColumn('event_briefs', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
