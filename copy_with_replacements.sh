#!/bin/bash 

FILES=
REPLACEMENTS=
FILE=1

for arg in $@; do
  if [[ $arg == '-e' ]]; then
    FILE=0
  elif [[ $FILE == 1 ]]; then
    [[ -d $arg && $arg != */ ]] && arg="$arg"/
    FILES="$FILES $arg"
  else
    REPLACEMENTS="$REPLACEMENTS -e $arg"
  fi
done

echo $FILES
echo $REPLACEMENTS

if [[ -z $FILES || -z $REPLACEMENTS ]]
then
  echo "Usage: $0 file [file2] ... -e sed-expressions"
  echo "The program asks for a replacement string"
  exit 0
fi

find $FILES | while read file; do
  target=`echo $file | sed $REPLACEMENTS`
  echo $file -\> $target
  if [[ -d $file ]]; then
    mkdir -p $target
  else
    sed $REPLACEMENTS $file > $target
  fi
done;
