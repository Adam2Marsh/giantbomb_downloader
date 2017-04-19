#!/usr/bin/env bash
# Use this script to install Giantbomb Downloader onto a Debian OS

tmpLog=/tmp/gbdownloader-install.log

GIT_PROJECT_URL=https://github.com/Adam2Marsh/giantbomb_downloader.git
INSTALLER_DEPS=(git whiptail wget apt-transport-https lsb-release ca-certificates)
GB_DOWNLOADER_DEPS=(libapache2-mod-php php7.1 php7.1-sqlite3 php7.1-odbc php7.1-mbstring php7.1-curl php7.1-mcrypt php7.1-xml php7.1-cli php7.1-dev apache2 sqlite redis-server supervisor)

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

# Makes apt-get non-interactive
export DEBIAN_FRONTEND=noninteractive

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

    echo "-*- Installing required packages for installer to run"
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

    echo "-*- Installing required packages for the tool to run"
    sudo apt-get update
    sudo -E apt-get -q -y install ${GB_DOWNLOADER_DEPS[@]}
}

GrabGiantbombDownloaderFromGit() {

    sudo chmod 777 /opt
    cd /opt

    echo "-*- Checking if you already have the project cloned"
    if [ -d "giantbomb_downloader" ]; then
        echo "-*- You do! Just pulling latest version"
        cd giantbomb_downloader
        sudo git pull
    else
        echo "-*- You don't! Cloning Repo"
        git clone ${GIT_PROJECT_URL}
    fi
}

ConfigureDb() {

    echo "-*- Configuring DB"
    touch /opt/giantbomb_downloader/database/database.sqlite
}

ComposerInstall() {

    echo "-*- Running Composer to install site"
    cd /opt/giantbomb_downloader
    ./composer.phar install
}

CreateEnvFile() {

    echo "-*- Creating env file"
    echo "DB_CONNECTION=sqlite" >> "/opt/giantbomb_downloader/.env"
    echo "APP_KEY=" >> "/opt/giantbomb_downloader/.env"
}

ConfigureSupervisor() {

    echo "-*- Configuring Supervisor"
    sudo supervisorctl stop all
    sudo cp -R /opt/giantbomb_downloader/automated_install/configs/supervisor/* /etc/supervisor/conf.d/
    sudo supervisorctl reread
    sudo supervisorctl start all
}

SetupLaravelFramework() {

    echo "-*- Final Install Step for Laravel Framework"
    chmod 777 -R /opt/giantbomb_downloader/storage/
    php /opt/giantbomb_downloader/artisan key:generate
    php /opt/giantbomb_downloader/artisan migrate --force
}

SymlinkGiantbombDownloader() {

    echo "-*- Create Symlink in apache web root so we can access"
    sudo ln -s /opt/giantbomb_downloader/public /var/www/html/giantbomb_downloader
}

ConfigureApache() {

    sudo a2dismod php7.0
    sudo a2enmod php7.1
    sudo a2enmod rewrite
    sudo cp /opt/giantbomb_downloader/automated_install/configs/apache2/giantbomb_downloader.conf /etc/apache2/sites-available/giantbomb_downloader.conf

    sudo service apache2 reload
}

ConfigureCron() {

    sudo cp /opt/giantbomb_downloader/automated_install/configs/crontab/giantbomb_downloader /etc/cron.d/giantbomb_downloader
}


SudoCheck
PackageManagerCheck
InstallPackagesRequiredForInstallScript
WelcomeDialogs
InstallPackagesRequiredForGiantbombDownloader
GrabGiantbombDownloaderFromGit
ConfigureDb
ComposerInstall
CreateEnvFile
SetupLaravelFramework
ConfigureSupervisor
SymlinkGiantbombDownloader
ConfigureApache
ConfigureCron