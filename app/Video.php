<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Video extends Model
{
    use Notifiable;

    private $slack_webhook_url = "https://hooks.slack.com/services/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";

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
        return $this->slack_webhook_url;
        // return "https://hooks.slack.com/services/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";
    }

}
