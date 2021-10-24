# Задание 1.

Из директории, в которой расположен файл task_one.php, выполнить команду: <br/>
php task_one.php path/to/directory1 path/to/directory2 <br />
Результат: сумма всех чисел во всех файлах, которые получилось открыть.
Если директории не переданы - скрипт будет считать сумму чисел в своей директории. <br/>
Также сделан юнит-тест.

###Примечание:
Из соображений отказоустойчивости - если файл не удается открыть - этот файл пропускаем.
Встречаю Throwable - т.к. возможны и Exception и Error.

---
#Задание 2.
Тут намудрил:) <br />
Отчасти потому, что в начале думал, что раз библиотека для композера, то и воспользоваться ей может кто угодно.
А не только какое-то одно предприятие с одним сервером example.com, частным репозиторием и одним типом комментариев.
Поэтому получилась вот такая реализация.

####Принцип работы:
1. Выполнить установку пакетов
2. В файле config/config.php можно задать настройки класса комментария и сервера.
3. Подключение библиотеки через класс CommentService. В конструкторе можно налету установить конфиг из п.1, если нужно. 
4. Вызвать нужный метод (на просмотр/добавление/обновление) в котором - передать необходимый набор атрибутов для своего типа комментария и сервера.

Использованные зависимости: <br />
"guzzlehttp/guzzle" - для отправки http запросов на сервер example.com <br />
"rakit/validation": - для валидации комментария
