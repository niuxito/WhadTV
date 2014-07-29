#!/bin/sh

 #ffmpeg -i $1 -vcodec libvpx -s $2x$3 $4.webm
 nice -n -20 ffmpeg -i $1  -s $2x$3 $4.webm
 ffmpeg -i $4.webm -vcodec libx264 -strict -2 -s $2x$3 $4.mp4
 #ffmpeg -i $4.webm  -strict -2 -s $2x$3 $4.mp4
