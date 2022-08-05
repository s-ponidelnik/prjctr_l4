#!/bin/bash
echo 'Concurrency 10...';
docker exec prjctr_l4_php php flush.php && siege -b -c10 -v -t60s -f ./var/www/siege/simpleCache_urls.txt > ./logs/simple_cache_10 && echo 'simple_cache_10 ready!'
siege -b -c10 -v -t60s -f ./var/www/siege/noCache_urls.txt > ./logs/no_cache_10 && echo 'no_cache_10 ready!'
docker exec prjctr_l4_php php flush.php && siege -b -c10 -v -t60s -f ./var/www/siege/probEarlyExpCache_urls.txt > ./logs/prob_early_exp_cache_10 && echo 'prob_early_exp_cache_10 ready!'
#
echo 'Concurrency 25...';
docker exec prjctr_l4_php php flush.php && siege -b -c25 -v -t60s -f ./var/www/siege/simpleCache_urls.txt > ./logs/simple_cache_25 && echo 'simple_cache_25 ready!'
siege -b -c25 -v -t60s -f ./var/www/siege/noCache_urls.txt > ./logs/no_cache_25 && echo 'no_cache_25 ready!'
docker exec prjctr_l4_php php flush.php && siege -b -c25 -v -t60s -f ./var/www/siege/probEarlyExpCache_urls.txt > ./logs/prob_early_exp_cache_25 && echo 'prob_early_exp_cache_25 ready!'

echo 'Concurrency 50...';
docker exec prjctr_l4_php php flush.php && siege -b -c50 -v -t60s -f ./var/www/siege/simpleCache_urls.txt > ./logs/simple_cache_50 && echo 'simple_cache_50 ready!'
siege -b -c50 -v -t60s -f ./var/www/siege/noCache_urls.txt > ./logs/no_cache_50 && echo 'no_cache_50 ready!'
docker exec prjctr_l4_php php flush.php && siege -b -c50 -v -t60s -f ./var/www/siege/probEarlyExpCache_urls.txt > ./logs/prob_early_exp_cache_50 && echo 'prob_early_exp_cache_50 ready!'

echo 'Concurrency 100...';
docker exec prjctr_l4_php php flush.php && siege -b -c100 -v -t60s -f ./var/www/siege/simpleCache_urls.txt > ./logs/simple_cache_100 && echo 'simple_cache_100 ready!'
siege -b -c100 -v -t60s -f ./var/www/siege/noCache_urls.txt > ./logs/no_cache_100 && echo 'no_cache_100 ready!'
docker exec prjctr_l4_php php flush.php && siege -b -c100 -v -t60s -f ./var/www/siege/probEarlyExpCache_urls.txt > ./logs/prob_early_exp_cache_100 && echo 'prob_early_exp_cache_100 ready!'