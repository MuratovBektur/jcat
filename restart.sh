git pull;
source docker-compose-name.sh;

# устанавливаем зависимости для laravel чтобы 
# можно было сбилдит server через docker compose
# и выставляем права 
cd server && ./install_package_and_set_permissions.sh && cd ..;

rm -f client/.env
cp configs/client/.env client/.env;

cd client;
source ./build.sh;
cd ..;
# собираем все файлы переменного окружения в один файл
cat configs/.env configs/client/.env configs/server/.env > .env;

"${DOCKER_COMPOSE[@]}" -f docker-compose.yml down -v;
"${DOCKER_COMPOSE[@]}" -f docker-compose.yml up -d --build;
"${DOCKER_COMPOSE[@]}" -f docker-compose.yml logs -f --tail=100;