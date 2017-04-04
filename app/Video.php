<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Config;

class Video extends Model
{
    use Notifiable;

    protected $dates = [
    	'created_at',
    	'published_date',
    	'updated_at,'
    ];

    /**
     * Get the phone record associated with the user.
     */
    public function videoDetail()
    {
        return $this->hasOne('App\VideoDetails');
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return Config::where('name', 'SLACK_HOOK_URL')->first();
    }

}
