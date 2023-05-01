# Домашнее задание


Решение запускается в docker. Для проверки также потребуется docker-compose.  
  
  
  
После клонирования репозитория выполнить:  
1) docker compose up -d  
2) docker compose exec backend composer install  
3) В /etc/hosts добавить строку  
- 127.0.0.1       backend.demo.test phpmyadmin.demo.test  
  
  
  
Запуск тестов:  
- docker compose exec backend vendor/bin/phpunit  
  
  
  
Выполнить миграции и наполнить БД тестовыми данными:  
- docker compose exec backend php artisan migrate --seed
  
  
  
Доступные url:  
- http://backend.demo.test/  
- http://phpmyadmin.demo.test 
 
 
 
Для простоты работа приложения и тесты выполняются на одном экземпляре БД.
