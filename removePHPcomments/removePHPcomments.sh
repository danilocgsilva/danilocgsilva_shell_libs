#!/bin/bash
# source: https://gist.github.com/ugoletti/904745

find . -type f -name "*.php" | while read file; do sed -i -e '/\/\*/,/*\//d; /^[[:space:]]*\/\//d; /^$/d;' $file;done

