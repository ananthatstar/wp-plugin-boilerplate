#!/bin/bash

# Author: Ananth B <ananthatstar@gmail.com>
# License: GPLv3
# Version: 1.0.0

set_defaults() {
    VERSION='1.0.0'
    PLUGIN_DIR='.plugin'
    GITHUB_USER='ananthatstar'
    GITHUB_REPO='wp-plugin-boilerplate'
}

get_plugin_name() {
    echo -n "What is your plugin name? \033[0;33m[eg: WP Plugin]\033[39m: "
    read PLUGIN_NAME
    if [ -z "$PLUGIN_NAME" ]; then
        get_plugin_name
    fi
}

get_plugin_description() {
    echo -n "What is your plugin description? \033[0;33m[ie: short description]\033[39m: "
    read PLUGIN_DESC
    if [ -z "$PLUGIN_DESC" ]; then
        get_plugin_description
    fi
}

get_plugin_slug() {
    echo -n "What is your plugin slug? \033[0;33m[eg: wp-plugin]\033[39m: "
    read PLUGIN_SLUG
    if [ -z "$PLUGIN_SLUG" ]; then
        get_plugin_slug
    fi
}

get_plugin_version() {
    echo -n "What is your plugin version? \033[0;33m[default: 1.0.0]\033[39m: "
    read PLUGIN_VERSION
    if [ -z "$PLUGIN_VERSION" ]; then
        PLUGIN_VERSION="1.0.0"
    fi
}

get_plugin_prefix() {
    echo -n "What is your plugin prefix? \033[0;33m[should be unique, eg: WPP]\033[39m: "
    read PLUGIN_PREFIX
    if [ -z "$PLUGIN_PREFIX" ]; then
        get_plugin_prefix
    fi
}

get_plugin_license() {
    echo -n "What is your plugin license? \033[0;33m[GPL/MIT]\033[39m: "
    read PLUGIN_LICENSE
    if [ -z "$PLUGIN_LICENSE" ] || [ "$PLUGIN_LICENSE" != "GPL" -a "$PLUGIN_LICENSE" != "MIT" ]; then
        get_plugin_license
    fi
    if [ "$PLUGIN_LICENSE" = "GPL" ]; then
        PLUGIN_LICENSE="GPL v3 or later"
        PLUGIN_LICENSE_URL="https://www.gnu.org/licenses/gpl-3.0.html"
    elif [ "$PLUGIN_LICENSE" = "MIT" ]; then
        PLUGIN_LICENSE="MIT"
        PLUGIN_LICENSE_URL="https://opensource.org/licenses/MIT"
    fi
}

get_plugin_url() {
    echo -n "What is your plugin url? \033[0;33m[ie, plugin website]\033[39m: "
    read PLUGIN_URL
    if [ -z "$PLUGIN_URL" ]; then
        get_plugin_url
    fi
}

get_author_name() {
    echo -n "What is your name? \033[0;33m[ie, author's name]\033[39m: "
    read AUTHOR_NAME
    if [ -z "$AUTHOR_NAME" ]; then
        get_author_name
    fi
}

get_author_email() {
    echo -n "What is your email? \033[0;33m[ie, author's email]\033[39m: "
    read AUTHOR_EMAIL
    if [ -z "$AUTHOR_EMAIL" ]; then
        get_author_email
    fi
}

get_author_copyright() {
    echo -n "What is your copyright? \033[0;33m[format: YYYY Company name]\033[39m: "
    read AUTHOR_COPYRIGHT
    if [ -z "$AUTHOR_COPYRIGHT" ]; then
        get_author_copyright
    fi
}

get_author_license() {
    echo -n "What is your license? \033[0;33m[GPL/MIT]\033[39m: "
    read AUTHOR_LICENSE
    if [ -z "$AUTHOR_LICENSE" ] || [ "$AUTHOR_LICENSE" != "GPL" -a "$AUTHOR_LICENSE" != "MIT" ]; then
        get_author_license
    fi
    if [ "$AUTHOR_LICENSE" = "GPL" ]; then
        AUTHOR_LICENSE="GPL-3.0-or-later"
    elif [ "$PLUGIN_LICENSE" = "MIT" ]; then
        AUTHOR_LICENSE="MIT"
    fi
}

get_author_url() {
    echo -n "What is your website url? \033[0;33m[author's website]\033[39m: "
    read AUTHOR_URL
    if [ -z "$AUTHOR_URL" ]; then
        get_author_url
    fi
}

check_dependency() {
    if [ ! -x "$(command -v wp)" ]; then
        echo "\033[0;31mwp-cli not installed! Aborted. \033[39m"
        exit 1
    fi

    if [ ! -x "$(command -v composer)" ]; then
        echo "\033[0;31mcomposer not installed! Aborted. \033[39m"
        exit 1
    fi

    if [ ! -x "$(command -v npm)" ]; then
        echo "\033[0;31mnpm not installed! Aborted. \033[39m"
        exit 1
    fi

    if [ ! -x "$(command -v zip)" ]; then
        echo "\033[0;31mzip not installed! Aborted. \033[39m"
        exit 1
    fi
}

license_notice() {
    echo '| This program is licensed under GPL https://www.gnu.org/licenses/gpl-3.0.html |'
    echo ''
    read -p 'Do you accept the license terms? [y/n]: ' AGREE_TO_PROCEED
    if [ -z "$AGREE_TO_PROCEED" ] || [ "$AGREE_TO_PROCEED" != "y" ] ; then
        echo '\033[0;31mAborted! \033[39m'
        exit 1
    fi
    echo ''
}

download_boilerplate() {
    echo 'Downloading plugin boilerplate from Git...'

    if [ -d ".temp" ]; then
        rm -rf .temp
    fi
    
    mkdir .temp && cd .temp

    git clone -q "https://github.com/$GITHUB_USER/$GITHUB_REPO"
    
    if [ ! -d "$GITHUB_REPO" ]; then
        exit 1
    fi

    mv $GITHUB_REPO ../$PLUGIN_DIR && cd .. && rm -rf .temp

    echo '\033[0;32mBoilerplate Download Completed. \033[39m'
}

rename_files() {
    if [ ! -z "$2" ]; then
        find . -type f -name "*$1*" | while read FILE; do
            NEW_FILE="$(echo ${FILE} | sed -e 's|'"$1"'|'"$2"'|')";
            mv "${FILE}" "${NEW_FILE}";
        done
    fi
}

replace_text_in_files() {
    if [ ! -z "$2" ]; then
        find . -type f -exec sed -i -e 's|'"$1"'|'"$2"'|g' {} +
    fi
}

run_npm_install() {
    echo ''
    echo 'Installing npm packages...'
    npm install --silent
    echo '\033[0;32mNPM packages installed. \033[39m'
}

run_composer_install() {
    echo ''
    echo 'Installing composer packages...'
    composer install -q
    echo '\033[0;32mComposer packages installed. \033[39m'
}

run_npm_build() {
    echo ''
    echo 'Running npm build...'
    npm run --silent build
    echo '\033[0;32mNpm build completed. \033[39m'
}

generate_pot_file() {
    echo ''
    echo 'Generating plugin POT file...'

    wp i18n make-pot . i18n/languages/"$PLUGIN_SLUG".pot --quiet

    cd i18n/languages/
    replace_text_in_files 'FULL NAME' "$AUTHOR_NAME"
    replace_text_in_files 'EMAIL@ADDRESS' "$AUTHOR_EMAIL"
    replace_text_in_files 'LANGUAGE <LL@li.org>' "$PLUGIN_NAME"
    replace_text_in_files 'YEAR-MO-DA HO:MI+ZONE' " "
    cd .. && cd ..

    echo '\033[0;32mPot file Generated. \033[39m'
}

generate_config_file() {
    echo ''
    echo 'Generating config file...'

    echo "PLUGIN_NAME=$PLUGIN_NAME" > .config
    echo "PLUGIN_SLUG=$PLUGIN_SLUG" >> .config
    echo "AUTHOR_NAME=$AUTHOR_NAME" >> .config
    echo "AUTHOR_EMAIL=$AUTHOR_EMAIL" >> .config

    echo '\033[0;32mConfig file Generated. \033[39m'
}

export_zip_file() {
    echo ''
    echo 'Exporting plugin files to Zip...'

    if [ -f "$PLUGIN_SLUG".zip ]; then
        rm "$PLUGIN_SLUG".zip
    fi

    if [ -d ".temp" ]; then
        rm -rf .temp
    fi

    mkdir .temp && cd .temp
    mkdir $PLUGIN_SLUG && cd ..

    cp -r * .temp/"$PLUGIN_SLUG" && cd .temp/

    zip -r -q "../$PLUGIN_SLUG".zip * -x '*/composer.*' -x '*/package.json' -x '*/package-lock.json' -x '*/node_modules/*' -x '*/assets/scss/*' -x '*/LICENSE' -x '*/README.md' -x '*/plugin.sh'

    cd .. && rm -rf .temp

    echo '\033[0;32mZip Export Completed. \033[39m'
}

build() {
    check_dependency
    if [ ! -f ".config" ] && [ -f "config.php" -o -d $PLUGIN_DIR ]; then
        echo ''
        get_plugin_name
        get_plugin_description
        get_plugin_slug
        get_plugin_version
        get_plugin_prefix
        get_plugin_license
        get_plugin_url
        echo ''
        get_author_name
        get_author_email
        get_author_copyright
        get_author_license
        get_author_url

        if [ -d "$PLUGIN_DIR" ]; then
            mv $PLUGIN_DIR $PLUGIN_SLUG
            cd $PLUGIN_SLUG
        fi

        if [ -d ".git" ]; then
            rm -rf .git
        fi

        rename_files 'plugin-slug' $PLUGIN_SLUG
        replace_text_in_files '{plugin_name}' "$PLUGIN_NAME"
        replace_text_in_files '{plugin_description}' "$PLUGIN_DESC"
        replace_text_in_files '{plugin_slug}' $PLUGIN_SLUG
        replace_text_in_files '{plugin_version}' "$PLUGIN_VERSION"

        replace_text_in_files 'PREFIX' "$(echo $PLUGIN_PREFIX | sed -e 's/\(.*\)/\U\1/')"
        replace_text_in_files '{prefix}' "$(echo $PLUGIN_PREFIX | sed -e 's/\(.*\)/\L\1/')"

        replace_text_in_files '{plugin_license}' "$PLUGIN_LICENSE"
        replace_text_in_files '{plugin_license_url}' $PLUGIN_LICENSE_URL
        replace_text_in_files '{plugin_url}' $PLUGIN_URL

        replace_text_in_files '{author_name}' "$AUTHOR_NAME"
        replace_text_in_files '{author_email}' $AUTHOR_EMAIL
        replace_text_in_files '{author_copyright}' "$AUTHOR_COPYRIGHT"
        replace_text_in_files '{author_license}' $AUTHOR_LICENSE
        replace_text_in_files '{author_url}' $AUTHOR_URL

        run_npm_install
        run_composer_install

        generate_config_file
    elif [ -f ".config" ]; then
        export $(cat .config | xargs)
    else
        echo '\033[0;31mUnable to build! \033[39m'
        exit 1
    fi

    run_npm_build

    generate_pot_file

    export_zip_file

    echo ''
    echo "\033[0;32mPlugin $PLUGIN_NAME is generated successfully! \033[39m"
    echo ''
    echo "\033[0;32mHappy Coding :) \033[39m"
}

create() {
    license_notice
    check_dependency
    if [ ! -f ".config" ]; then
        download_boilerplate
        build
    else 
        echo '\033[0;33mPlugin already exists. \033[39m'
        exit 1
    fi
}

set_defaults
echo '|============ WP Plugin (MVC pattern) Boilerplate Generator v1.0.0 ============|'
if [ -z "$1" ]; then
    echo ''
    echo '\033[0;31mArgument required. \033[39m'
    exit 1
elif [ "$1" = "new" ]; then
    create
elif [ "$1" = "build" ]; then
    build
elif [ "$1" = "version" ]; then
    echo $VERSION
else
    echo ''
    echo '\033[0;31mInvalid Argument. \033[39m'
    exit 1
fi