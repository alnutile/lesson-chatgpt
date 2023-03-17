<?php

namespace App\Http\Controllers;

use App\PromptTransformers\ImageRequestToPromptData;
use App\Transformers\ImageResponse;
use Carbon\Carbon;
use Facades\App\Transformers\BarberShopResults;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ExamplesController extends Controller
{

    public function mainInterface() {

        return inertia("MainInterface/Index");

    }

    public function ask() {
        $validated = request()->validate(['input' => ['required']]);

        $question = $validated['input'];

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $question,
            'temperature' => .25,
            'max_tokens' => 800,
        ]);

        $result = data_get($result, 'choices.0.text');

        return response()->json($result);
    }

    public function exampleImage() {

        /**
         * https://gist.github.com/ozh/8143e5978a7bd0d85b725c9dc34a2451
         * https://dallery.gallery/dall-e-ai-guide-faq/
         * https://prompthero.com/dall-e-prompts
         * https://www.dallepedia.com/2022/07/04/10-illustration-styles-to-explore-in-dall-e/
         */
        return inertia("Image/Index", [
            'example_prompts' => [
                'sand sculpture of _____',
                '____ behind frosted glass',
                'Hyper realistic pencil drawing of _____',
                'Astronaut staring into the cosmos, floating through deep space, beautiful galaxies in background',
                "Intricate alien ruins of crumbling black stone, in an extraterrestrial landscape",
                "3D render of a floating futuristic castle in a clear sky, digital art",
                "hovering house in palm springs synthwave",
                "pink ape Astronaut in space holding a claymate in a photorealistic style, digital art"
            ],
            'styles' => [
                'Realism',
                'Minimalism',
                'vintage',
                'illuminated letters',
                'intricate lettering',
                'Geometric abstract',
                'Surrealism',
                'Psychedelic',
                'Vector',
                '3D illustration',
                'photorealistic',
                'in the style of Dr. Seuss',
                'in the style of MC Escher',
                'flat art',
                'digital art',
            ],
            'genre' => [
                "fantasy",
                "Science Fiction",
                "Children’s Book",
                "Concept Art",
                "Comics / Graphic Novel",
                "Cartoons",
                "Caricature",
                "Advertising and Logos",
                "Cards",
            ]
        ]);

    }


    public function exampleImageRequest() {
        $validated = request()->validate(
            [
                'prompt' => ['required'],
                'genres' => ['nullable'],
                'styles' => ['nullable'],
            ]
        );

        $prompt = ImageRequestToPromptData::from($validated);

        $result = OpenAI::images()->create([
            'prompt' => $prompt->generatePrompt(),
            'n' => 1,
            'size' => '256x256',
            'response_format' => 'url',
        ]);


        $response = ImageResponse::from($result->toArray());

        return response()->json($response->returnAllImageUrls());
    }


    public function exampleBarberShop() {

        $timeList = [];
        $time = Carbon::createFromTime(8, 0, 0);
        while ($time->lte(Carbon::createFromTime(16, 30, 0))) {
            $timeFormatted = $time->format('h:i A');
            $timeList[] = $timeFormatted;
            $time->addMinutes(30);
        }


        foreach(range(1, 30) as $days) {
            $date = now()->addDays($days);
            $range[] = $date->toFormattedDayDateString();
        }

        return inertia("BarberShop/Index", [
            'days' => $range,
            'start_time' => $timeList,
            'end_time' => $timeList
        ]);

    }



    public function exampleBarberShopRequest() {
        $validated = request()->validate(
            [
                'start' => ['required'],
                'end' => ['required'],
                'day' => ['required'],
            ]
        );

        /**
         * Image this comes from the database for example;
         * select * from staff
         * LEFT JOIN schedule on schedule.staff_id = staff.id
         *
         * select * from staff
         * LEFT JOIN days_off on days_off.staff_id = staff.id
         *
         * Below we will just fake some days and times and make a question from that as if it was from the database and
         * we iterated over an array
         */
        $context = <<<EOD
A customer wants a haircut sunday {$validated['day']}, between {$validated['start']} and {$validated['end']}, we have four barbers on that day.
Bob who works 9am to 4pm, sam who works 9am to 2pm, Jen who works 9am to 3pm, Steve who works 9am to 7pm.
People who have days off are Jen March 18th. Lunch breaks are as follows, Bob 12pm to 1pm, Sam 1pm to 2pm, Steve 11am to 12pm
Haircuts take 30 minutes can you suggest two possible timeslots for the customer.
EOD;


        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $context,
            'temperature' => .25,
            'max_tokens' => 800,
        ]);

        $result = data_get($result, 'choices.0.text');


        return response()->json(BarberShopResults::handle($result));
    }

    public function examplePlanning() {

        return inertia("Planning/Index");

    }
}
