<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function generateDeskripsi($prompt)
    {
        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah guru TK yang menulis laporan perkembangan anak.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

        // Logging jika gagal
        if ($response->failed()) {
            Log::error('OpenAI API failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        $content = $response->json('choices.0.message.content');

        if (!$content) {
            Log::warning('OpenAI response missing content', [
                'full_response' => $response->json(),
            ]);
        }

        return $content;
    }
}
