## Задание 1
Есть массив целых чисел расположенных по порядку [1,2,5,7, ... 158 .... 10000000]. 

Напишите оптимальную функцию, которая определит, есть ли число 6562848 в этом массиве. 

#### Решение:
[Вариант решения](https://github.com/avkey89/book24/blob/master/src/Services/SearchInArray.php)

## Задание 2
У нас есть массив подготовленных к записи сообщений, который выглядит следующим образом: 
```
array(
    array(
        'firm_id' => N,
        'subject' => S,
        'body'    => S,
        'from'    => S,
        'to'      => S
    ),
    .....
    array(
        'firm_id' => N,
        'subject' => S,
        'body'    => S,
        'from'    => S,
        'to'      => S
    )
)
```
Сообщения пишутся в N - количество баз данных с одинаковой структурой. Сервер, на который необходимо записать данные определяется в зависимости от firm_id. Напишите оптимальный, по вашему мнению, алгоритм обработки и записи этих данных.

#### Решение:
[Вариант решения](https://github.com/avkey89/book24/blob/master/src/Services/MessageService.php)

Данное решение хорошо подходит при условии, что базы размещены локально на сервере, либо имеют возможность подключение из вне (внешний адрес).
При условии, что базы запрещены для работы из вне и размещены физически на разных серверах, то в этом случае можно воспользоваться системами очередей.

## Задание 3.
Есть таблица books со структурой: 

book_id, title, description, author_id, status, date (timestamp)

Таблица authors: 

author_id, name

Предположим, что у нас в базе хранятся 1 000 000 книг и нам необходимо сделать вывод списка книг с авторами и постраничной навигацией, книги со статусом (status) равным двум и отсортированным по дате (date). 
Напишите, как бы Вы это сделали и какие индексы (если нужно) Вы бы добавили к таблицам и почему? 
```$xslt
// variant 1
SELECT b.*, a.name author_name
FROM books b
LEFT JOIN authors a
    ON b.author_id = a.author_id
WHERE b.status = 2
ORDER BY b.date ASC
LIMIT ?, 100

// variant 2
SELECT b.*,
    (SELECT a.name FROM authors a WHERE a.author_id = b.author_id) author_name
FROM books AS b
WHERE b.status = 2
ORDER BY b.date ASC
LIMIT ?, 100

// indexes
create index if not exists books_status_index on books (status);
create index if not exists books_date_index on books (date);
```

## Задание 4. 
Реализовать Rest API эндпоинт для проведения транзакции начисления условных единиц (денег или баллов) от одного пользователя на счет другого. Баланс не может быть отрицательным. В БД проекта должно быть как минимум две обязательных таблицы: пользователи и транзакции.

В рамках этой задачи эндпоинт должен быть доступен без авторизации.

Написать интеграционные тесты, покрывающие как минимум два любых тесткейса (например успешную транзакцию и неуспешную).

Подумать, какие подводные камни могут возникнуть при использовании этого эндпоинта в реальном проекте.

Код должен быть оформлен по стандарту PSR-12. Использовать Php 7.4, Последнюю минорную версию Symfony 4/5, любую удобную реляционную СУБД. Для тестов использовать PhpUnit.
Должна быть возможность развернуть проект локально и запустить тесты.

### Окружение
Окружение для запуска проекта реализовано с помощью docker и docker-compose. Управлять запуском можно через обертку `make`

#### Основные команды
`make init` - Сборка контейнеров, их запуск, установка composer пакетов, запуск миграций и добавление фикстур

`make up` - Запуск контейнеров

`make down` - Остановка контейнеров

`make restart` - Перезапуск контейнеров

`make test` - Запуск unit тестов 

### Работа
При запуске проекта через команду `make init` автоматически создаются 10 тестовых пользователей с e-mail (`useremail0@test.ru`, `useremail1@test.ru` и т.д. до `useremail9@test.ru`) и балансом равным 1000 для каждого пользователя.
 
Для выполнения запроса на перевод баланса, необходимо осуществить `POST` запрос по адресу `http://localhost:8000/transaction` с телом запроса
```json
{
    "from_user": "useremail0@test.ru",
    "to_user": "useremail1@test.ru",
    "amount": 100
}
```
где:

`from_user` - email пользователя у которого осуществляется списание средств,

`to_user` - email пользователя, которому осуществляется перевод средств,

`amount` - сумма перевода.

Результат запроса:

- В случае успешного перевода вернется статус 201 в заголовке и тело ответа:
```json
{
    "message": "Transaction successfully created"
}
```
- В случае ввода некорректных данных или неправильной суммы результатом работы API будет статус 400 и тело ответа с сообщением ошибки, с указанием на конкретную проблему, например:
```json
{
    "message": "Insufficient funds to transfer"
}
```
или
```json
{
    "message": "amount:\n ERROR: Negative translations are prohibited\n"
}
```
##### Проблемы, возможные при использовании эндпоинта на реальном проекте
1. Отсутствует безопасность приложения: нет авторизации, подтверждений операций.
2. Если данное API будет работать в фоне (cron, очереди), то нет возможности отследить все ли операции были проведены, какие были ошибки - нет логирования шагов.
3. В данной реализации не учтена проблема, при которой запросы могут поступить одновременно и, следовательно, баланс может быть не актуален. (блокировка)