# Create Github repository

Uses the github API to automates the task of creating a repository

Usage:

Pré-requisite:
1. Have a working PHP web server. Can be yout local site development

Usage:

1. Moves the programfiles/php files to your web server.
2. Change the informations inside createrepo.confs.php to your credentials.
Obs.: The $registered_user of this file is merely a security feature and does not have any relationship to git or github api. If not, any web source could create freely any number of repositories inside your personal github repository! It is recommended to not put the same github username for better security.
3. Copy createrepo and the folder createrepo_program with its contents to /usr/local/bin (or any path included in your path variable). Does not forgot to alter permission to execute the createrepo
4. In the terminal, writes: createrepo <your-web-address-holding-the-php-files> <yout-secure-registeres-user-in-configs-php-files>