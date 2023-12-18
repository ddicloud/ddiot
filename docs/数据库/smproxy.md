docker build -t smproxy:latest .
docker run -d -p 3366:3366 smproxy:latest
php74 bin/SMProxy restart
