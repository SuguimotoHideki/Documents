<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Events\ReviewCreated;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SubmissionTypeSeeder::class);

        \App\Models\User::factory(45)->create();
        \App\Models\Event::factory(45)->create();

        $users = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        $mods = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'event moderator');
        })->get();

        $reviewers = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'reviewer');
        })->get();

        $events = \App\Models\Event::all();

        $types = \App\Models\SubmissionType::all();

        //Check submission types
        foreach($events as $event)
        {
            $event->submissionTypes()->attach(
                $types->random(rand(1, 6))->pluck('id')->toArray()
            );
        }

        //Create subscriptions and submissions
        foreach($users as $user)
        {
            $subbedEvents = $events->random(rand(1, 25))->pluck('id')->toArray();
            $user->events()->attach($subbedEvents);
            foreach($user->events as $sub)
            {
                $typeId = $sub->submissionTypes->random()->id;

                $document = \App\Models\Document::factory(1)->create(['submission_type_id' => $typeId]);
                
                \App\Models\Submission::create([
                    'event_id' => $sub->id,
                    'document_id' => $document[0]->id,
                    'user_id' => $user->id,
                    'status' => 3
                ]);
            }
        }

        //Assign moderators
        foreach($mods as $mod)
        {
            $modEvents = $events->random(rand(1, 25))->pluck('id')->toArray();
            $mod->eventsModerated()->attach($modEvents);
        }

        $documents = \App\Models\Document::all();

        //Assign reviewers and create reviews
        foreach($reviewers as $reviewer)
        {
            $reviewDoc = $documents->random(rand(1, 30))->pluck('id')->toArray();
            $reviewer->documents()->attach($reviewDoc);
            $reviewer->givePermissionTo('switch roles');
        }

        //Create reviews
        //Assign reviewers and create reviews
        foreach($reviewers as $reviewer)
        {
            foreach($reviewer->documents as $review)
            {
                \App\Models\Review::factory(1)->create([
                    'user_id' => $reviewer->id,
                    'document_id' => $review->id,
                ]);
                ReviewCreated::dispatch($review->submission, true);
                //event (new ReviewCreated($review->submission, true));
            }
        }
    }
}
