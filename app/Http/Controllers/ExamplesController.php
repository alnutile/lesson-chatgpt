<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ExamplesController extends Controller
{

    public function mainInterface() {

        return inertia("MainInterface/Index");

    }

    public function ask() {
        $validated = request()->validate(['question' => ['required']]);

        $question = $validated['question'];

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => 'PHP is',
        ]);



        put_fixture("example_results.json", $result);
        dd($result);

        return response()->json($result);
    }

    public function examplePlanning() {

        return inertia("Planning/Index");

    }
}
