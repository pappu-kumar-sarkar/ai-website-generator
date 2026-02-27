<?php

namespace App\Http\Controllers;

use App\Models\SubProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Project;


class ProjectController extends Controller
{
    public function generateComponentProject(Request $request)
    {
        try {

            $userPrompt = $request->user_prompt;

            if (!$userPrompt) {
                return response()->json([
                    'status' => false,
                    'error' => 'Prompt required'
                ], 400);
            }

            // 1️⃣ Create Project
            $project = Project::create([
                'project_name' => 'AI Project',
                'user_prompt' => $userPrompt
            ]);

            // 2️⃣ JSON Structure
            $structure = [
                "header" => [
                    "hero_title" => "",
                    "hero_tagline" => "",
                    "color" => "",
                    "background" => ""
                ],
                "about_us" => [
                    "about_text" => ""
                ],
                "footer" => [
                    "contact_text" => ""
                ]
            ];

            $prompt = "
            Fill this JSON structure only.
            Return pure JSON only.
            " . json_encode($structure, JSON_PRETTY_PRINT);

            // 3️⃣ Call Gemini
            $response = Http::post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    "contents" => [
                        [
                            "parts" => [
                                ["text" => $prompt]
                            ]
                        ]
                    ]
                ]
            );

            $data = $response->json();

            $aiContent = $data['candidates'][0]['content']['parts'][0]['text'];

            $decoded = json_decode($aiContent, true);

            // 4️⃣ Save Sub Project
            SubProjects::create([
                'project_id' => $project->id,
                'header' => $decoded['header'] ?? null,
                'about_us' => $decoded['about_us'] ?? null,
                'footer' => $decoded['footer'] ?? null,
            ]);

            return response()->json([
                'status' => true,
                'data' => $decoded
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}