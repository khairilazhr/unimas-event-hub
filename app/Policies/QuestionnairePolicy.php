<?php
namespace App\Policies;

use App\Models\Questionnaire;
use App\Models\User;

class QuestionnairePolicy
{
    public function view(User $user, Questionnaire $questionnaire)
    {
        return $user->id === $questionnaire->organizer_id;
    }

    public function update(User $user, Questionnaire $questionnaire)
    {
        return $user->id === $questionnaire->organizer_id;
    }

    public function delete(User $user, Questionnaire $questionnaire)
    {
        return $user->id === $questionnaire->organizer_id;
    }
}
