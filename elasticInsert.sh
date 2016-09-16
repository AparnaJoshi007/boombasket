#!/bin/bash

i=0
length=`cat games.json|jq length`
while [ $i -le $length ]
do
b=`cat games.json|jq ".[$i]"`
curl -XPOST "http://localhost:9200/shopping/games/" -d "$b"
((i++))
done

