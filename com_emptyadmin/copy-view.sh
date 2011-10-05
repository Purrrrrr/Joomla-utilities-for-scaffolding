#!/bin/bash
BASEDIR="`dirname $0`"

if [ -z $1 -o -z $2 ] 
then
  echo "Usage: copy-view.sh dir/to/new/view dir/to/template/view"
  echo "The view directory will be created for you and a name choosen according to the directory you choose"
  exit 0
fi

TARGET=`readlink $1`
VIEWNAME=`basename $TARGET`
VIEWNAMECAPS=`echo $VIEWNAME |  sed -e 's/^./\U&/g'`
COMPONENTDIR=`dirname \`dirname $TARGET\``
COMPONENTNAME=`grep -oP "(?<=class ).*?(?=Controller)" $COMPONENTDIR/controller.php`
TEMPLATE=`readlink $2`
TEMPLATENAME=`basename $TEMPLATE`
TEMPLATENAMECAPS=`echo $TEMPLATENAME |  sed -e 's/^./\U&/g'`
TEMPLATECOMPONENTDIR=`dirname \`dirname $TEMPLATE\``
TEMPLATECOMPONENTNAME=`grep -oP "(?<=class ).*?(?=Controller)" $TEMPLATECOMPONENTDIR/controller.php`
  

for path in `find $TEMPLATE`
do
  file=${path:${#BASEDIR}} #Extract filename without path

  if [ -d $path ] 
  then
    mkdir $TARGET$file
  else
    sed "s/$TEMPLATECOMPONENTNAME/$COMPONENTNAME/" $path | sed "s/$TEMPLATENAMECAPS/$VIEWNAMECAPS/" > $TARGET$file
  fi

done
