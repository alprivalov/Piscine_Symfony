#!/bin/bash

input=$(curl "$1" -i --silent | grep "Location" | cut --complement -d  ' ' -f 1)
echo "$input"