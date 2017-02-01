# Install this

Automatically installs all the programs from this githu project

To do: In the loop step (step 7), the utility fails to rewrite those scripts in the /usr/local/bin that have a permission with precedence that those used by the executing script user. Before replace file (that also may not exists in some circunstance), must test if the permission allow. If not, summarize the problem in the end of the script, listing all files that could not be replaced.
