<?php

namespace Database\Seeders;

use App\Models\Attenndee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $events = Event::all();
        foreach ($users as $user) {
            $eventsToAttendee = $events->random(rand(1,3));

            foreach ($eventsToAttendee as $event) {
                Attenndee::create([
                    'user_id'=>$user->id,
                    'event_id'=>$event->id

                ]);
            }
        }
    }
}
