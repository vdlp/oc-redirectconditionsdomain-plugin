#!/usr/bin/env bash

rm -f ./build/oc-redirectconditionsdomain-plugin.zip
zip -r ./build/oc-redirectconditionsdomain-plugin.zip . -x@build-exclude.txt
