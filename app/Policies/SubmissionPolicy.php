<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->role === 'GLaDOS';
    }

    public function view(User $user, Submission $submission): bool
    {
        if ($user->role === 'GLaDOS') {
            return true;
        }

        return $user->subject_id === $submission->user_subject_id;
    }
}
