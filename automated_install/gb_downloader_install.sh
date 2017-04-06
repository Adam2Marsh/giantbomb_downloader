#!/usr/bin/env bash
# Use this script to install Giantbomb Downloader onto a Debian OS

tmpLog=/tmp/gbdownloader-install.log

######## FIRST CHECK ########
# Must be root to install
echo "-*-"
if [[ $EUID -eq 0 ]];then
	echo "-*- You are root."
else
	echo "-*- sudo will be used for the install."
	# Check if it is actually installed
	# If it isn't, exit because the install cannot complete
	if [ -x "$(command -v sudo)" ];then
		export SUDO="sudo"
	else
		echo "-*- sudo is needed for the Web interface to run pihole commands.  Please run this script as root and it will be automatically installed."
		exit 1
	fi
fi

if [ -x "$(command -v apt-get)" ];then
    echo "-*- Okay"
else
    echo "-*- This script will only install on a apt-get OS, sorry! Quiting"
    exit
fi
