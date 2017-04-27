## Giantbomb Downloader

If your reading this then our situations could be similar, you love GiantBomb and your internet is just not that great... I developed this tool to download my favourite Giantbomb videos ready for my morning commute, while my power hungry PC and I sleep.

I present Giantbomb Downloader:
![Giantbomb Look](github_images/FrontPage.png)

It's not perfect, and looks a little ugly currently but works. Thought I'd put out there first to see if anyone else might find useful. I've still got a few things on my trello board I'd like to add, and if alot of people find it useful maybe I'll spend some more time it.

## Features
* Checks for New Giantbomb Videos every Hour
* Download videos onto your Pi, ready to download from Pi saving you time
* **My Favourite Feature!!!** Ability to set up automatic downloads of your favourite video series (rules page)
* Integration with Slack to sign up to notifications when new videos can be downloaded or have been downloaded

## Who can use this?
Anyone who has a giantbomb account, you need one as it uses their api.

## How does it work?
TLDR: It's a PHP Site which uses the Giantbomb API to fetch latest videos. It needs to be hosted and was designed to work and run on a Rapsberry Pi.    

I built the tool using the [Laravel Framework](https://laravel.com/) and [Giantbomb's API](https://www.giantbomb.com/api/).

## How to Install?
The below script has been tested with a Raspberry Pi running Debian Jessie, if you want to install randomly then check the install script for manual steps. 
``` shell
curl -sSL https://raw.githubusercontent.com/Adam2Marsh/giantbomb_downloader/master/automated_install/gb_downloader_install.sh | bash
```

## Contributing
If your using the tool and think its missing a key feature then raise an issue with as much detail as possible. Thanks!

## License
The Giantbomb Downloader is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Want to say thanks?
I've had fun developing it while at the same time learning the Laravel Framework in my spare time. You can use for free and I expect nothing but if you want to say thanks,
 * Send me a tweet [@Adam2Marsh](https://twitter.com/Adam2Marsh)
 * Buy me a McDonalds Meal via a Paypal Donate [![](https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=RGEBE58NW4ZMA&lc=GB&item_name=Adam2Marsh&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted)
 
 But remember I expect nothing **:)**
