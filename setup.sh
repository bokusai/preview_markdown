#!/bin/bash
set +x
rm -f cakephp/app/tmp/cache/models/cake_* 
rm -f cakephp/app/tmp/cache/persistent/cake_*
rm -f cakephp/app/tmp/cache/views/cake_*
chmod -R 777 cakephp/app/tmp
chmod -R 777 FileDB/*

echo "done"

