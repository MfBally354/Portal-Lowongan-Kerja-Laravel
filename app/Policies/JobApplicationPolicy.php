<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    public function view(User $user, JobApplication $application): bool
    {
        return $user->id === $application->job->company->user_id 
            || $user->id === $application->user_id;
    }

    public function update(User $user, JobApplication $application): bool
    {
        return $user->id === $application->job->company->user_id;
    }
}
