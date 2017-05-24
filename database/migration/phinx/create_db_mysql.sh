#!/bin/bash
set -o nounset

mysql -uroot -p -e "CREATE DATABASE IF NOT EXISTS demo"
mysql -uroot -p -e "CREATE DATABASE IF NOT EXISTS demo_dev"
mysql -uroot -p -e "CREATE DATABASE IF NOT EXISTS demo_test"
