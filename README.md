# rabbitmq-examples


### Требования

Для запуска примеров у вас должен быть установлен [docker-compose](https://docs.docker.com/compose/install/)

### Подготовка

```bash
git clone https://github.com/ildarsaitkulov/rabbitmq-examples
cd rabbitmq-examples && docker-compose up --build
```

### Запуск примеров
Запустим один из примеров publisher http://127.0.0.1:8000/publisher_direct_exchange.php, который создаст direct exchange и queue, и отправит в rabbitMQ тестовые данные.

Таким же образом можно запустить остальные примеры.

### Management Plugin

RabbitMQ предоставляет плагин для управления через браузер. После запуска докер контейнера, панель управления будет доступна по ссылке http://127.0.0.1:15672/. 

Для авторизации используйте логин и пароль **guest**.
