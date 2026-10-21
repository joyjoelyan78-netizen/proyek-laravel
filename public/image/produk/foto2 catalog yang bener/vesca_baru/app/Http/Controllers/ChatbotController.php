<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        try {

            $client = OpenAI::client(
                env('OPENAI_API_KEY')
            );

            $response = $client->chat()->create([

                'model' => 'gpt-3.5-turbo',

                'messages' => [
                    [
                        'role' => 'system',
                        'content' =>
                        'Kamu adalah customer service PT Vescarindo Utama.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message
                    ]
                ]
            ]);

            return response()->json([
                'reply' =>
                $response->choices[0]->message->content
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'reply' =>
                'Error: ' . $e->getMessage()
            ]);
        }
    }
}