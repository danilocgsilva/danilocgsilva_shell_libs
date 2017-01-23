#!/bin/bash

createrepo_util(){
	
	declare -a createrepo_util_errors
	
	if [ -z $1 ]; then
		createrepo_util_errors+=('You need the first argument to be the path to the php. It is empty.');
	fi

	if [ -z $2 ]; then
		createrepo_util_errors+=('You need the second argument to be the registered user. It is empty.')
	fi
	
	if [ ${#createrepo_util_errors[@]} -gt 0 ]; then
		# If there's errors, skip, exiting the program
		for i in `seq ${#createrepo_util_errors[@]}`; do
			realloop=`expr $i - 1`
			echo createrepo_util error: ${createrepo_util_errors[$realloop]}
		done
		return
	fi

	# Get current folder name to be the project name
	projectname=$(basename $(pwd))

	IFS=$'\n'
	content_response=($(curl "$1/createrepo.php?registereduser=$2&projname=$projectname"))

	github_user=${content_response[3]}

	createrepo_util_gitinit $projectname
}

createrepo_util_gitinit(){
	echo "# $1" >> README.md
	git init
	git add -A
	git commit -m "first commit"
	git remote add origin git@github.com:$github_user/$1.git
	git push -u origin master
}
