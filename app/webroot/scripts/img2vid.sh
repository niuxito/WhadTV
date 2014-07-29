#!/bin/sh

ffmpeg -loop 1 -f image2 -i $1  -t $2 -q:a 1 $3

