<?php

namespace App\Jobs;

use App\Models\Activity;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateActivityForUsersJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Activity $activity, protected int|null $userId)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $activities = [];

        if ($this->activity->is_global) {
            $userIds = User::select(['id', 'user_type'])
                ->where('user_type', '=', User::USER)
                ->pluck('id');

            foreach ($userIds as $userId) {
                $activities[] = $this->formatActivity() + ['user_id' => $userId];
            }
        }
        else {
            $activities[] = $this->formatActivity() + ['user_id' => $this->userId];
        }

        Revision::insert($activities);
    }

    private function formatActivity(): array
    {
        return [
            'activity_id' => $this->activity->id,
            'title'       => $this->activity->title,
            'description' => $this->activity->description,
            'image'       => $this->activity->image
        ];
    }
}
