#!/bin/bash
BASEDIR="`dirname $0`"

if [ -z $1 -o -z $2 ] 
then
  echo "Usage: copy-view.sh dir/to/source/views/view dir/to/target/views/view"
  echo "Copies a joomla view directory and changes the classname according to the chosen directory name and component."
  exit 0
fi
TEMPLATE=`readlink -f $1`
TEMPLATENAME=`basename $TEMPLATE`
TEMPLATENAMECAPS=`echo $TEMPLATENAME |  sed -e 's/^./\U&/g'`
TEMPLATECOMPONENTDIR=`dirname \`dirname $TEMPLATE\``
TEMPLATECOMPONENTNAME=`grep -oP "(?<=class ).*?(?=Controller)" $TEMPLATECOMPONENTDIR/controller.php`
  
TARGET=`readlink -f $2`
VIEWNAME=`basename $TARGET`
VIEWNAMECAPS=`echo $VIEWNAME |  sed -e 's/^./\U&/g'`
COMPONENTDIR=`dirname \`dirname $TARGET\``
COMPONENTNAME=`grep -oP "(?<=class ).*?(?=Controller)" $COMPONENTDIR/controller.php`

if [ -z $COMPONENTNAME -o -z $TEMPLATECOMPONENTNAME ] 
then
  TEMPLATECOMPONENTNAME=" "
  COMPONENTNAME=" "
fi

if [ -d $TARGET ] 
then
  echo "Target directory already exists"
  exit
fi 

for path in `find $TEMPLATE`
do
  file=${path:${#TEMPLATE}} #Extract filename without path

  if [ -d $path ] 
  then
    mkdir $TARGET$file
  else
    echo $TARGET$file
    sed "s/${TEMPLATECOMPONENTNAME}View/${COMPONENTNAME}View/g" $path | sed "s/$TEMPLATENAMECAPS/$VIEWNAMECAPS/g" | sed "s/$TEMPLATENAME/$VIEWNAME/g" > $TARGET$file
  fi

done
