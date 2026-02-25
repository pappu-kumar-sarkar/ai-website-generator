<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GeneratedWebsite;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function generate(Request $request)
    {
        try {

            $userPrompt = $request->user_prompt;   // textarea prompt
            $category = $request->category;
            $design = $request->design;

            if (!$userPrompt || !$category || !$design) {
                return response()->json([
                    'status' => false,
                    'error' => 'All fields are required'
                ], 400);
            }

            /*
            🔥 Requirement Based Prompt Generation
            System internally generate 2 prompts
            */

            // Prompt 1 - Header
            $promptHeader = "
            {$userPrompt}
            Category: {$category}
            Design Style: {$design}

            Create a Header section for webpage using HTML, CSS and JS.
            Include logo and navigation menu.
            ";

            // Prompt 2 - Hero
            $promptHero = "
            {$userPrompt}
            Category: {$category}
            Design Style: {$design}

            Create a Hero section using HTML, CSS and JS.
            Include headline, subheading and call-to-action button.
            ";

            // Combine Prompts
            $finalPrompt = $promptHeader . "\n\n" . $promptHero;

            // 🔥 OpenAI API Call
            $response = Http::withToken(env('OPENAI_API_KEY'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4.1-mini',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $finalPrompt
                        ]
                    ],
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'status' => false,
                    'error' => $response->body()
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['choices'][0]['message']['content'])) {
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid AI response format'
                ], 500);
            }

            $aiContent = $data['choices'][0]['message']['content'];

            // 🔥 Save in Database
            GeneratedWebsite::create([
                'business_type' => $userPrompt,
                'category' => $category,
                'design' => $design,
                'prompt' => $finalPrompt,
                'ai_response' => $aiContent
            ]);

            return response()->json([
                'status' => true,
                'html' => $aiContent
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function generateWithGemini(Request $request)
    {
        try {

            $userPrompt = $request->user_prompt;
            $category = $request->category;
            $design = $request->design;

            if (!$userPrompt || !$category || !$design) {
                return response()->json([
                    'status' => false,
                    'error' => 'All fields are required'
                ], 400);
            }

            // 🔥 Prompt 1 - Header
            $promptHeader = "
        {$userPrompt}
        Category: {$category}
        Design Style: {$design}

        Create a Header section using HTML, CSS and JS.
        Include logo and navigation menu.   
        ";

            // 🔥 Prompt 2 - Hero
            $promptHero = "
        {$userPrompt}
        Category: {$category}
        Design Style: {$design}

        Create a Hero section using HTML, CSS and JS.
        Include headline, subheading and call-to-action button.
        ";

            $finalPrompt = $promptHeader . "\n\n" . $promptHero;

            $finalPrompt .= "

    CRITICAL OUTPUT RULES (STRICTLY FOLLOW):

        1. Return ONLY valid, complete HTML5 code.
        2. Do NOT include markdown formatting.
        3. Do NOT use ``` or ```html blocks.
        4. Do NOT add explanation, comments, or extra text.
        5. Output must start exactly with: <!DOCTYPE html>
        6. Output must end with: </html>
        7. Include internal <style> inside <head>.
        8. Make the design modern, responsive and professional.
        9. Use clean spacing, proper typography and good color contrast.
        10. Do NOT say 'Here is your website'.

        The response must contain only raw HTML code.
    ";
            set_time_limit(120);
            // 🔥 Gemini API Call
            $response = Http::post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    "contents" => [
                        [
                            "parts" => [
                                ["text" => $finalPrompt]
                            ]
                        ]
                    ]
                ]
            );

            // dd($response->json());

            if (!$response->successful()) {
                return response()->json([
                    'status' => false,
                    'error' => $response->body()
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid Gemini response format'
                ], 500);
            }

            $aiContent = $data['candidates'][0]['content']['parts'][0]['text'];

            // 🔥 Save in Database
            GeneratedWebsite::create([
                'business_type' => $userPrompt,
                'category' => $category,
                'design' => $design,
                'prompt' => $finalPrompt,
                'ai_response' => $aiContent
            ]);

            return response()->json([
                'status' => true,
                'html' => $aiContent
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}