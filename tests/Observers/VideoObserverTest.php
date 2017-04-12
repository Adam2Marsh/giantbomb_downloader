<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\Notifications\NewVideoNotification;
use App\Notifications\VideoDownloadedNotification;
use App\Notifications\VideoDownloadingNotification;
use App\Notifications\VideoQueuedNotification;
use App\Events\BrowserForceRefreshEvent;

use App\Video;

class VideoObserverTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test the new Video Notification
     */
    public function test_NewVideoNotificationFired()
    {
        Notification::fake();

        $video = new Video;
        $video->name = "NotificationCreatedTest";
        $video->save();

        Notification::assertSentTo (
            $video,
            NewVideoNotification::class
        );
    }

    /**
     * Test Queued Video Notification
     */
    public function test_VideoQueuedNotificationFired()
    {
        Notification::fake();

        $video = new Video;
        $video->name = "NotificationQueuedTest";
        $video->save();

        $video->status = "QUEUED";
        $video->save();

        Notification::assertSentTo (
            $video,
            VideoQueuedNotification::class
        );
    }

    /**
     * Test Downloading Notification
     */
    public function test_VideoDownloadingNotificationFired()
    {
        Notification::fake();

        $video = new Video;
        $video->name = "NotificationDownloadingTest";
        $video->save();

        $video->status = "DOWNLOADING";
        $video->save();

        Notification::assertSentTo (
            $video,
            VideoDownloadingNotification::class
        );
    }

    /**
     * Test Downloaded Notification
     */
    public function test_VideoDownloadedNotificationFired()
    {
        Notification::fake();

        $video = new Video;
        $video->name = "NotificationDownloadedTest";
        $video->save();

        $video->status = "DOWNLOADED";
        $video->save();

        Notification::assertSentTo (
            $video,
            VideoDownloadedNotification::class
        );
    }

    /**
     * Test Created Event
     */
    public function test_BrowserForceRefreshEventVideoCreated()
    {
        Event::fake();
        Notification::fake();

        $video = new Video;
        $video->name = "EventCreatedTest";
        $video->save();

        Event::assertFired (
            BrowserForceRefreshEvent::class
        );
    }

    /**
     * Test Downloaded Event
     */
    public function test_BrowserForceRefreshEventVideoUpdated()
    {
        Event::fake();
        Notification::fake();

        $video = new Video;
        $video->name = "EventDownloadedTest";
        $video->save();

        $video->status="DOWNLOADED";
        $video->save();

        Event::assertFired (
            BrowserForceRefreshEvent::class
        );
    }
}
