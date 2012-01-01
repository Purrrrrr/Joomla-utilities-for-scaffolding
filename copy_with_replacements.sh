#!/bin/bash 

if [ -z $1 ] 
then
  echo "Usage: $0 file [file2] ..."
  echo "The program asks for a replacement string"
  exit 0
fi

regexp=1
REPLACEMENTS=""
while [[ -n $regexp ]]; do
  echo "Replace:"
  read regexp
  if [[ -z $regexp ]]; then break; fi;
  echo "With:"
  read replacement
  regexp="`echo "$regexp" | sed -e "s/\\//\\\\\\\\\\\\//g" -e "s/&/\\\\\&/g"`"
  replacement="`echo "$replacement" | sed -e "s/\\//\\\\\\\\\\\\//g" -e "s/&/\\\\\&/g"`"
  REPLACEMENTS="$REPLACEMENTS -e s/$regexp/$replacement/g"
done

find $@ | while read file; do
  target=`echo $file | sed $REPLACEMENTS`
  if [[ -d $file ]]; then
    mkdir $target
  else
    echo sed $REPLACEMENTS $file \> $target
  fi
done;
