#!/bin/bash

TEMPLATE='emptyadmin'
TEMPLATECAPS=`echo $TEMPLATE |  sed -e 's/^./\U&/g'`
BASEDIR="`dirname $0`/com_$TEMPLATE"

if [ -z $1 ] 
then
  echo "Usage: create-template.sh dir/to/new/component"
  echo "The new component directory will be created for you"
  exit 0
fi

TARGET=$1
COMPONENTNAME=`basename $TARGET`
COMPONENTNAMECAPS=`echo $COMPONENTNAME |  sed -e 's/^./\U&/g'`

echo Creating component $TEMPLATENAME into $TARGET
echo "What is the component name \"$COMPONENTNAME\" in uppercase? Press enter to use \"$COMPONENTNAMECAPS\""
read COMPONENTNAMECAPS_RAW 
echo "What is the component description?"
read DESCRIPTION_RAW

if [ ! -z "$COMPONENTNAMECAPS_RAW" ]
then
  COMPONENTNAMECAPS="`echo "$COMPONENTNAMECAPS_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"
fi 
DESCRIPTION="`echo "$DESCRIPTION_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"

for path in `find $BASEDIR`
do
  if [ "$path" = "$BASEDIR/$TARGET" -o "$path" = "$BASEDIR/$TEMPLATE.xml" ]
  then
    continue
  fi
  file=${path:${#BASEDIR}}
  #file has / as first char

  if [ -d $path ] 
  then
    mkdir $TARGET$file
  else
    echo $TARGET$file
    sed "s/$TEMPLATE/$COMPONENTNAME/" $path |
      sed "s/$TEMPLATECAPS/$COMPONENTNAMECAPS/" > $TARGET$file
  fi
done

echo $TARGET/$COMPONENTNAME.xml
mv $TARGET/$TEMPLATE.php $TARGET/$COMPONENTNAME.php
sed "s/component_description/$DESCRIPTION/" "$BASEDIR/$TEMPLATE.xml" |
   sed "s/component_creation_date/`date +%d.%m.%Y`/" |
   sed "s/$TEMPLATE/$COMPONENTNAME/" > "$TARGET/$COMPONENTNAME.xml"
