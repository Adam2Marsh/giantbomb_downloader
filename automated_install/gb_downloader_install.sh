#!/usr/bin/env bash
# Use this script to install Giantbomb Downloader onto a Debian OS

tmpLog=/tmp/gbdownloader-install.log

GIT_PROJECT_URL=https://github.com/Adam2Marsh/giantbomb_downloader.git
INSTALLER_DEPS=(git whiptail wget apt-transport-https lsb-release ca-certificates)
GB_DOWNLOADER_DEPS=(libapache2-mod-php php7.1 php7.1-mysql php7.1-odbc php7.1-mbstring php7.1-mcrypt php7.1-xml php7.1-cli php7.1-dev apache2 mysql-server redis-server supervisor)

DATABASE_PASSWORD=`date +%s | sha256sum | base64 | head -c 32`

# Find the rows and columns will default to 80x24 is it can not be detected
screen_size=$(stty size 2>/dev/null || echo 24 80)
rows=$(echo "${screen_size}" | awk '{print $1}')
columns=$(echo "${screen_size}" | awk '{print $2}')

# Divide by two so the dialogs take up half of the screen, which looks nice.
r=$(( rows / 2 ))
c=$(( columns / 2 ))
# Unless the screen is tiny
r=$(( r < 20 ? 20 : r ))
c=$(( c < 70 ? 70 : c ))


SudoCheck() {

    # Must be root to install
    echo "-*-"
    if [[ $EUID -eq 0 ]];then
        echo "-*- You are root."
    else
        echo "-*- Sudo will be used for the install."
    fi
}

PackageManagerCheck() {

    if [ -x "$(command -v apt-get)" ];then
        echo "-*- Okay"
    else
        echo "-*- This script will only install on a apt-get OS, sorry! Quiting"
        exit 1
    fi
}

InstallPackagesRequiredForInstallScript() {

    sudo apt-get update
    sudo apt-get install -y ${INSTALLER_DEPS[@]}
    sudo sh -c 'echo "deb http://repozytorium.mati75.eu/raspbian jessie-backports main contrib non-free" >> /etc/apt/sources.list'
    sudo sh -c 'gpg --keyserver pgpkeys.mit.edu --recv-key CCD91D6111A06851; gpg --armor --export CCD91D6111A06851 | apt-key add -'
}

WelcomeDialogs() {

    whiptail --msgbox --title "Giantbomb Downloader Automated Installer" "\n\nThis tool will automatically install Giantbomb Downloader Tool" ${r} ${c}

    whiptail --msgbox --title "Giantbomb Downloader Automated Installer" "\n\nBefore we start going to check a few things I require for setup" ${r} ${c}
}

InstallPackagesRequiredForGiantbombDownloader() {

    export DEBIAN_FRONTEND=noninteractive  
    
    sudo apt-get update
    sudo apt-get install -q -y ${GB_DOWNLOADER_DEPS[@]}
}

GrabGiantbombDownloaderFromGit() {

    cd /var/www

    echo "-*- Checking if you already have the project cloned"
    if [ -d "giantbomb_downloader" ]; then
        echo "-*- You do! Just pulling latest version"
        cd giantbomb_downloader
        sudo git pull
    else
        echo "-*- You don't! Cloning Repo"
        sudo git clone ${GIT_PROJECT_URL}
    fi
}

ConfigureApache() {

    sudo service apache2 stop
    sudo cp /var/www/giantbomb_downloader/automated_install/configs/apache2/giantbomb_downloader.conf /etc/apache2/sites-available/giantbomb_downloader.conf
    sudo a2ensite giantbomb_downloader.conf
    sudo service apache2 start
    sudo service apache2 reload
}

ConfigureMysqlDatabase() {

    mysql -ve "CREATE USER 'gb'@'localhost' IDENTIFIED BY '${DATABASE_PASSWORD}'"
    mysql -ve "CREATE DATABASE IF NOT EXISTS giantbomb"
    mysql -ve "GRANT ALL ON giantbomb.* TO 'gb'@'localhost'"
    mysql -ve "FLUSH PRIVILEGES"
}

ComposerInstall() {

    cd /var/www/giantbomb_downloader
    /var/www/giantbomb_downloader/composer.phar install
}

CreateEnvFile() {

    sudo echo "DB_PASSWORD=${DATABASE_PASSWORD}" >> "/var/www/giantbomb_downloader/.env"
    sudo echo "APP_KEY=" >> "/var/www/giantbomb_downloader/.env"
}

ConfigureSupervisor() {

    sudo supervisorctl stop all
    sudo cp -R /var/www/giantbomb_downloader/automated_install/configs/supervisor/* /etc/supervisor/conf.d/
    sudo supervisorctl reread
    sudo supervisorctl start all
}

SetupLaravelFramework() {

    sudo chmod 777 -R /var/www/giantbomb_downloader/storage/
    sudo php /var/www/giantbomb_downloader/artisan key:generate
    sudo php /var/www/giantbomb_downloader/artisan migrate
}

SudoCheck
PackageManagerCheck
InstallPackagesRequiredForInstallScript
WelcomeDialogs
InstallPackagesRequiredForGiantbombDownloader
GrabGiantbombDownloaderFromGit
ConfigureMysqlDatabase
ConfigureApache
ComposerInstall
CreateEnvFile
SetupLaravelFramework
ConfigureSupervisor
