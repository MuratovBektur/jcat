git pull;

# получем имя докер композера 
# (либо docker compose либо docker-compose)
# по которому можно обращятся
source docker-compose-name.sh;

# устанавливаем зависимости для laravel чтобы 
# можно было сбилдит server через docker compose
# и выставляем права 
cd server && ./install_package_and_set_permissions.sh && cd ..;

# выставляем все переменые окружение из файлов наружу
set -a
source configs/server/.env
source configs/client/.env
source configs/.env
set +a

# билдим клиент в папку client/dis,
# чтобы потом вставить её в nginx контейнер
rm -f client/.env 
cp configs/client/.env client/.env;

cd client;
source ./build.sh;
cd ..;

"${DOCKER_COMPOSE[@]}" -f docker-compose.yml down -v;
"${DOCKER_COMPOSE[@]}" -f docker-compose.yml up -d --build;
"${DOCKER_COMPOSE[@]}" -f docker-compose.yml logs -f --tail=100;