# RoboCF

Задача: 
=====================

Используя любой PHP-фреймворк создать приложение, которое имеет следующие возможности: любой пользователь приложения может выбрать любого другого пользователя приложения (кроме себя), чтобы сделать отложенный перевод денежных средств со своего счета на счет выбранного пользователя. При планировании такого перевода пользователь указывает сумму перевода в рублях, дату и время, когда нужно произвести перевод. Сумма перевода ограничена балансом клиента на момент планирования перевода с учетом ранее запланированных и невыполненных его исходящих переводов. Дата и время выбирается с точностью до часа с использованием календаря. Способ выбора пользователя - любой (можно просто ввод ID). Ввод данных должен валидироваться как на стороне клиента, так и на стороне сервера с выводом ошибок пользователю.

Показать на сайте список всех пользователей и информацию об их одном последнем переводе с помощью одного SQL-запроса к БД.

Реализовать сам процесс выполнения запланированных переводов. Не допустить ситуации, при которой у какого-либо пользователя окажется отрицательный баланс.

Написанный для решения задачи код не должен содержать уязвимостей. Процесс регистрации и проверки прав доступа можно не реализовывать. Для этого допустимо добавить дополнительное поле ввода для указания текущего пользователя. Внешний вид страниц значения не имеет.

Решение задачи должно содержать:

Весь текст поставленного тестового задания. 

Четкую инструкцию по развертыванию проекта с целью проверки его работоспособности. Приветствуется использование Docker. 

Миграции и сиды для наполнения БД демонстрационными данными.

Разворачивание проекта: 
=====================

1: Установить [Docker и Docker Compose](https://docks.docker.com/compose/install/),
а так же убедиться 
что текущей пользователь имеет права на использование docker 

2: Глобально установить 
[Composer](https://getcomposer.org/doc/03-cli.md#global)
(проект внутри использует команду composer install, 
так же можно ощучествить сборку зависимостей любым другим удобным способом)

3: Скопировать все файлы в свою систему в папку RoboCF

    git clone https://github.com/Grey1406/RoboCF.git RoboCF
    
4: Перейти в дирректорию RoboCF

    cd RoboCF

5: Собрать докер контейнер с приложением 

    make docker-up 
    или
    docker-compose up --build -d

6: Инициализировать приложение
    
    make install
    
если выполнение этой команды завершается с ошибкой, 
попробуйте запустить команды из makefile по одной для цели install

Сайт доступен на http://localhost:8080/

Для корректной работы отложенных переводов необходимо воспользоваться демоном cron:

    crontab -e

В конце файла указать

     * * * * * docker exec robocf_app_1 php artisan schedule:run >> /dev/null 2>&1 

Сохранить и выйти
