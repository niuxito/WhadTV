#!/bin/sh

ffmpeg -i $1 -vf thumbnail,scale=$2:$3 -frames:v $4 $5
