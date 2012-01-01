#!/bin/bash

TEMPLATE='emptyadmin'
TEMPLATE_ITEM='emptyitem'
TEMPLATECAPS=`echo $TEMPLATE |  sed -e 's/^./\U&/g'`
TEMPLATEALLCAPS=`echo $TEMPLATE |  sed -e 's/./\U&/g'`
TEMPLATE_ITEMCAPS=`echo $TEMPLATE_ITEM |  sed -e 's/^./\U&/g'`
BASEDIR="`dirname $0`/com_$TEMPLATE"

if [ -z $1 ] 
then
  echo "Usage: create-template.sh dir/to/new/component"
  echo "The new component directory will be created for you"
  exit 0
fi

TARGET=$1
COMPONENTNAME=`basename $TARGET`
if [ ${COMPONENTNAME:0:4} = 'com_' ]
then
  COMPONENTNAME=${COMPONENTNAME:4}
fi
COMPONENTNAMECAPS=`echo $COMPONENTNAME |  sed -e 's/^./\U&/'`
COMPONENTNAMEALLCAPS=`echo $COMPONENTNAME |  sed -e 's/./\U&/g'`
ITEM_NAME=item

echo Creating component $TEMPLATENAME into $TARGET
echo "What is the component name \"$COMPONENTNAME\" in uppercase? Press enter to use \"$COMPONENTNAMECAPS\""
read COMPONENTNAMECAPS_RAW 
if [ -n "$COMPONENTNAMECAPS_RAW" ]; then
  COMPONENTNAMECAPS="`echo "$COMPONENTNAMECAPS_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"
fi 

echo "What is the component description?"
read DESCRIPTION_RAW
DESCRIPTION="`echo "$DESCRIPTION_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"

echo "What is the item name used in this component? Press enter to use \"$ITEM_NAME\""
read ITEM_NAME_RAW 
if [ -n "$ITEM_NAME_RAW" ]; then
  ITEM_NAME="`echo "$ITEM_NAME_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"
fi

ITEM_NAMECAPS=`echo $ITEM_NAME |  sed -e 's/^./\U&/'`
echo "What is the item name \"$ITEM_NAME\" in uppercase? Press enter to use \"$ITEM_NAMECAPS\""
read ITEM_NAMECAPS_RAW 
if [ -n "$ITEM_NAMECAPS_RAW" ]; then
  ITEM_NAMECAPS="`echo "$ITEM_NAMECAPS_RAW" | sed "s/\\//\\\\\\\\\\\\//g" | sed "s/&/\\\\\&/g"`"
fi

for path in `find $BASEDIR`
do
  if [ "$path" = "$BASEDIR/$TARGET" -o "$path" = "$BASEDIR/$TEMPLATE.xml" ]
  then continue
  fi 
  file=`echo ${path:${#BASEDIR}} | sed "s/$TEMPLATE/$COMPONENTNAME/" | sed "s/$TEMPLATE_ITEM/$ITEM_NAME/"`

  if [ -d $path ] 
  then
    mkdir $TARGET$file
  else 
    echo $TARGET$file
    if [ ${file:0:9} = '/language' ]
    then
      sed "s/$TEMPLATEALLCAPS/$COMPONENTNAMEALLCAPS/" $path > $TARGET$file
    else 
      sed "s/$TEMPLATE/$COMPONENTNAME/g" $path |
        sed "s/$TEMPLATE_ITEM/$ITEM_NAME/g" |
        sed "s/$TEMPLATE_ITEMCAPS/$ITEM_NAMECAPS/g" |
        sed "s/$TEMPLATECAPS/$COMPONENTNAMECAPS/g" > $TARGET$file
    fi
  fi
done

echo $TARGET/$COMPONENTNAME.xml
sed "s/component_description/$DESCRIPTION/" "$BASEDIR/$TEMPLATE.xml" |
   sed "s/component_creation_date/`date +%d.%m.%Y`/" |
   sed "s/$TEMPLATE/$COMPONENTNAME/" > "$TARGET/$COMPONENTNAME.xml"

#ln -s `readlink -f \`dirname $0\``/copy_view.sh $TARGET/copy_view.sh
