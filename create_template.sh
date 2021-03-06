#!/bin/bash

BASEDIR="`dirname $0`/empty_template"

if [ -z $1 ] 
then
  echo "Usage: $0 dir/to/new/template"
  echo "The new template directory will be created for you"
  exit 0
fi

TARGET=$1
TEMPLATENAME=`basename $TARGET`

echo Creating template $TEMPLATENAME into $TARGET
echo "What is the theme description?"
read DESCRIPTION_RAW

DESCRIPTION="`echo "$DESCRIPTION_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"

if [ ! -d $TARGET ] 
then
  mkdir $TARGET
else
  echo "Target directory already exists"
  exit
fi

for path in `find $BASEDIR`
do
  if [ "$path" = "$BASEDIR/$TARGET" -o "$path" = "$BASEDIR" -o "$path" = "templateDetails.xml" ]
  then
    continue
  fi
  file=${path:${#BASEDIR}}
  #file has / as first char

  if [ -d $path ] 
  then
    mkdir $TARGET$file
  else
    sed "s/template_name/$TEMPLATENAME/" $path > $TARGET$file
  fi
done

mkdir "$TARGET/images"
mkdir "$TARGET/html"

sed "s/template_description/$DESCRIPTION/" "$BASEDIR/templateDetails.xml" |
   sed "s/template_creation_date/`date +%d.%m.%Y`/" |
   sed "s/template_name/$TEMPLATENAME/" > "$TARGET/templateDetails.xml"
