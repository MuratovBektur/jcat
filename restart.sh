git pull;
source docker-compose-name.sh;

cp configs/client/.env client/.env

cd client;
source ./build.sh;
cd ..;
# собираем все файлы переменного окружения в один файл
cat configs/.env configs/client/.env configs/server/.env > .env;

"${DOCKER_COMPOSE[@]}" -f docker-compose.yml down -v;
"${DOCKER_COMPOSE[@]}" -f docker-compose.yml up -d --build;
"${DOCKER_COMPOSE[@]}" -f docker-compose.yml logs -f --tail=100;