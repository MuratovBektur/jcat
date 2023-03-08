git pull;

source docker-compose-name.sh;

# устанавливаем зависимости для laravel чтобы 
# можно было сбилдит server через docker compose
cd server && ./install_packages.sh && cd ..;

# собираем все файлы переменного окружения в один файл
cat configs/.env.dev configs/client/.env.dev configs/server/.env.dev > .env;

"${DOCKER_COMPOSE[@]}" -f docker-compose.dev.yml down -v;
"${DOCKER_COMPOSE[@]}" -f docker-compose.dev.yml up -d --build;
"${DOCKER_COMPOSE[@]}" -f docker-compose.dev.yml logs -f --tail=100;