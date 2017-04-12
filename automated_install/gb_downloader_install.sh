#!/usr/bin/env bash
# Use this script to install Giantbomb Downloader onto a Debian OS

tmpLog=/tmp/gbdownloader-install.log

GIT_PROJECT_URL=https://github.com/Adam2Marsh/giantbomb_downloader.git
INSTALLER_DEPS=(git whiptail sudo wget apt-transport-https lsb-release ca-certificates)
GB_DOWNLOADER_DEPS=(php7.1 php7.1-mysql php7.1-odbc php7.1-mbstring php7.1-mcrypt php7.1-xml php7.1-cli php7.1-dev apache2 mysql-server redis-server supervisor)

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
        echo "-*- sudo will be used for the install."
        echo "-*- Please run script with Sudo as escalated privileges are required for installation"
        exit 1
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

    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
    sudo apt-get update
    sudo apt-get install -y ${INSTALLER_DEPS[@]}

}

WelcomeDialogs() {

    whiptail --msgbox --title "Giantbomb Downloader Automated Installer" "\n\nThis tool will automatically install Giantbomb Downloader Tool" ${r} ${c}

    whiptail --msgbox --title "Giantbomb Downloader Automated Installer" "\n\nBefore we start going to check a few things I require for setup" ${r} ${c}

    whiptail --msgbox --title "Giantbomb Downloader Automated Installer" "\n\nValidated OS and everything looks good, starting install" ${r} ${c}
}

InstallPackagesRequiredForGiantbombDownloader() {

    sudo apt-get install -y ${GB_DOWNLOADER_DEPS[@]}
}

GrabGiantbombDownloaderFromGit() {

    cd /var/www/html
    git clone ${GIT_PROJECT_URL}
}

ConfigureApache() {

    sudo service apache2 stop
    sudo cp /var/www/html/giantbomb_downloader/automated_install/configs/apache2/giantbomb_downloader.conf /etc/apache2/sites-available/giantbomb_downloader.conf
    sudo a2ensite giantbomb_downloader.conf
    sudo service apache2 start
}

ConfigureMysqlDatabase() {

    mysql -ve "CREATE USER 'gb'@'localhost' IDENTIFIED BY '${DATABASE_PASSWORD}'"
    mysql -ve "CREATE DATABASE IF NOT EXISTS gb"
    mysql -ve "GRANT ALL ON gb.* TO 'gb'@'localhost'"
    mysql -ve "FLUSH PRIVILEGES"
}

ConfigureSupervisor() {

    sudo supervisorctl stop all
    cp -R /var/www/html/giantbomb_downloader/automated_install/configs/supervisor/* /etc/supervisor/conf.d/
    sudo supervisorctl reread
    sudo supervisorctl start all
}

ComposerInstall() {

    /var/www/html/giantbomb_downloader/composer.phar install
}


SudoCheck
PackageManagerCheck
#InstallPackagesRequiredForInstallScript
WelcomeDialogs
#InstallPackagesRequiredForGiantbombDownloader
GrabGiantbombDownloaderFromGit
ConfigureMysqlDatabase
ConfigureSupervisor
ComposerInstall