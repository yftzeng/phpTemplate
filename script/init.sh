#!/bin/bash

if ( ! test -f "Makefile" || ! test -d "app" || ! test -d "public" || ! test -d "script" ) then
    echo "Please use this script in WEB ROOT, your are in $(pwd) now."
    exit
fi

OS=`lsb_release -a 2>/dev/null | awk '/^Description/ {print $2}'`

if ( test "$OS" = "Ubuntu" ) then
    WWW_USER="www-data"
elif ( test "$OS" = "Scientific" -o "$OS" = "CentOS" ) then
    WWW_USER="nginx"
else
    echo "OS not supported"
    exit
fi

ROOT=$(pwd)
CONFIG_ARRAY=( "app/config/config.php.sample:app/config/config.php" )
WWW_PERM_ARRAY=( "app/cache" "app/language/langcache/" "share" "var/log" )
REMOTE_STORATE_ARRAY=( "public/files" )

for element in ${CONFIG_ARRAY[@]}
do
    FROM=$(echo "$element" | awk -F':' '{print $1}')
    TO=$(echo "$element" | awk -F':' '{print $2}')

    if ( ! test -f "$FROM" ) then
        echo "$FROM is not found."
        exit 1
    fi

    cp -rpf $FROM $TO

    echo "Remember modify ==> $TO"
done

for element in ${WWW_PERM_ARRAY[@]}
do
    if ( ! test -d "$element" ) then
        mkdir -p "$ROOT/$element"
    fi
    sudo chown -R $WWW_USER:$WWW_USER $ROOT/$element
    sudo chmod 2777 $element
done

for element in ${REMOTE_STORATE_ARRAY[@]}
do
    if ( ! test -d "$element" ) then
        mkdir -p "$ROOT/$element"
    fi
    #find "$ROOT/$element" ! -perm 2777 -type d | while read d
    #do
        #echo "$d => chmod 2777"
        #sudo chmod 2777 "$d"
    #done
done

echo "...done"
