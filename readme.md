## Giantbomb Downloader

If your reading this then our situations could be similar, you love GiantBomb and your internet is just not that great... I developed this tool to download my favourite Giantbomb videos ready for my morning commute, while my power hungry PC and I sleep.

I present Giantbomb Downloader:
![Giantbomb Look](github_images/FrontPage.png)

## Features
* Checks for New Giantbomb Videos every Hour
* Download videos onto your Pi, ready to download from Pi saving you time
* **My Favourite Feature!!!** Ability to set up automatic downloads of your favourite video series (rules page)
* Integration with Slack to sign up to notifications when new videos can be downloaded or have been downloaded

## Who can use this?
I created this tool for **Premium Giantbomb Subscribers**, if your not a premium user then Giantbomb guys need your support in seeing ads when watching videos on their site! If your not a premium user this won't work; want to use this tool then help Giantbomb guys and become a premium user :)

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
I created this tool to allow me to download Giantbomb videos overnight without having to leave my PC on overnight ready for my commutes. I've had fun developing it while using it to learn the Laravel Framework. You can use for free and I expect nothing but if you want to say thanks you could:
 * Say thanks on Twitter [Adam2Marsh Twitter](https://twitter.com/Adam2Marsh)
 * Buy me a McDonalds Meal via a Paypal Donate [![](https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=RGEBE58NW4ZMA&lc=GB&item_name=Adam2Marsh&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted)
 
 But remember I expect nothing **:)**
