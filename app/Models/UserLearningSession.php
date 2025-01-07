<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLearningSession extends Model
{
    protected $table = 'user_sessions';

    protected $fillable = ['category_session_id', 'user_id', 'status', 'current_question_id', 'type'];

    public static function getUserLevel($user)
    {
        $points = $user->lerning_points()->sum('points');
        $levelImage = null;
        $nextLevelPoints = null;
        $imagesFolderUrl = asset('storage/site-images/learning_center');
        $levelsConfig = config('lc_config.point_levels');
        if ($points <= $levelsConfig['Novice']) {
            $levelImage = $imagesFolderUrl.'/Novice.png';
            $nextLevelPoints = $levelsConfig['Novice'];
        } elseif ($points > $levelsConfig['Novice'] && $points <= $levelsConfig['Intermediate']) {
            $levelImage = $imagesFolderUrl.'/Intermediate.png';
            $nextLevelPoints = $levelsConfig['Intermediate'];
        } elseif ($points > $levelsConfig['Intermediate'] && $points <= $levelsConfig['Advanced']) {
            $levelImage = $imagesFolderUrl.'/Advanced.png';
            $nextLevelPoints = $levelsConfig['Advanced'];
        } elseif ($points > $levelsConfig['Advanced'] && $points <= $levelsConfig['Expert']) {
            $levelImage = $imagesFolderUrl.'/Expert.png';
            $nextLevelPoints = $levelsConfig['Expert'];
        } else {
            $levelImage = $imagesFolderUrl.'/Professional.png';
            $nextLevelPoints = null;
        }

        return ['points' => $points, 'level_image' => $levelImage, 'next_level_points' => $nextLevelPoints];
    }
}
