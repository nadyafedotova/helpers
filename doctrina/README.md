Doctrina является библиотекой для работы с базой данных в фреймворке Symfony. Вот некоторые основные команды Doctrina Symfony:
## Создание таблиц базы данных на основе сущностей:
`php bin/console doctrine:schema:create`

## Обновление схемы базы данных на основе изменений в сущностях:
`php bin/console doctrine:schema:update --force`

## Генерация новой сущности:
`php bin/console doctrine:generate:entity`

## Генерация геттеров и сеттеров для сущности:
`php bin/console doctrine:generate:entities YourBundle:YourEntity`

## Генерация миграций на основе изменений в сущностях:
`php bin/console doctrine:migrations:diff`
## Применение миграций к базе данных:
`php bin/console doctrine:migrations:migrate`

## Создание нового репозитория:
`php bin/console doctrine:generate:repository`

## Генерация фикстур для заполнения базы данных тестовыми данными:
`php bin/console doctrine:fixtures:load`

## Просмотр списка доступных команд Doctrina:
`php bin/console list doctrine`

## Очистка метаданных кэша Doctrina:
`php bin/console doctrine:cache:clear-metadata`

## Очистка запросов кэша Doctrina:
`php bin/console doctrine:cache:clear-query`

## Очистка регионов кэша Doctrina:
`php bin/console doctrine:cache:clear-result`

## Генерация прокси-классов Doctrina для ленивой загрузки:
`php bin/console doctrine:generate:proxies`

## Просмотр информации о миграциях:
`php bin/console doctrine:migrations:status`

## Генерация классов миграций на основе текущего состояния базы данных:
`php bin/console doctrine:migrations:generate`

## Выполнение одной конкретной миграции:
`php bin/console doctrine:migrations:execute --up <version>`
`php bin/console doctrine:migrations:execute --down <version>`
## Создание базы данных, указанной в конфигурации:
`php bin/console doctrine:database:create`

## Удаление базы данных, указанной в конфигурации:
`php bin/console doctrine:database:drop --force`

## Генерация сущностей на основе существующей базы данных:
`php bin/console doctrine:mapping:import --force YourBundle annotation`

## Генерация сущностей на основе существующей базы данных с XML-аннотациями:
`php bin/console doctrine:mapping:import --force YourBundle xml`

## Генерация диаграммы базы данных на основе сущностей:
`php bin/console doctrine:mapping:convert annotation ./src/Entity --from-database --extend`

## Проверка сущностей на наличие ошибок:
`php bin/console doctrine:schema:validate`

## Создание сущностей на основе метаданных (аннотаций):
`php bin/console doctrine:generate:entities YourBundle`

## Создание сущностей на основе XML-метаданных:
`php bin/console doctrine:generate:entities YourBundle --path="./config/doctrine"`

## Генерация SQL-скрипта, который создаст базу данных:
`php bin/console doctrine:schema:create --dump-sql`

## Генерация SQL-скрипта, который обновит базу данных:
`php bin/console doctrine:schema:update --dump-sql`

## Выполнение DQL (Doctrine Query Language) запроса:
`php bin/console doctrine:query:dql 'SELECT u FROM App\Entity\User u'`

## Выполнение SQL-запроса:
`php bin/console doctrine:query:sql 'SELECT * FROM users'`

## Генерация сущностей на основе существующей базы данных с аннотациями в формате YAML:
`php bin/console doctrine:mapping:convert yml ./src/Entity --from-database --extend`

## Просмотр информации о метаданных сущностей:
`php bin/console doctrine:mapping:info`

## Генерация классов сущностей на основе существующей базы данных с аннотациями в формате PHP:
`php bin/console doctrine:mapping:convert annotation ./src/Entity --from-database --extend --php`

## Генерация классов сущностей на основе существующей базы данных с аннотациями в формате простых PHP-классов:
`php bin/console doctrine:mapping:convert simple_yaml ./config/doctrine --from-database --extend`

## Создание новой миграции на основе изменений в базе данных:
`php bin/console make:migration`

## Генерация классов миграций на основе сущностей:
`php bin/console make:entity --regenerate`

## Просмотр списка доступных миграций:
`php bin/console doctrine:migrations:list`

## Откат последней выполненной миграции:
`php bin/console doctrine:migrations:execute --down LastExecutedMigration`

## Генерация миграций на основе изменений в базе данных и применение их:
`php bin/console doctrine:migrations:migrate --dry-run`

## Генерация миграций на основе изменений в базе данных и применение только выбранных миграций:
`php bin/console doctrine:migrations:migrate YYYYMMDDHHMMSS`

## Генерация SQL-скрипта для отката всех миграций:
`php bin/console doctrine:migrations:execute --down --all-or-nothing`

## Генерация SQL-скрипта для применения всех миграций:
`php bin/console doctrine:migrations:execute --up --all-or-nothing`

## Генерация классов миграций на основе существующей базы данных с аннотациями в формате XML:
`php bin/console doctrine:mapping:convert xml ./config/doctrine --from-database --extend`

## Отображение информации о текущей базе данных:
`php bin/console doctrine:database:import`

## Выполнение миграций до указанной версии:
`php bin/console doctrine:migrations:migrate YYYYMMDDHHMMSS`
## Создание базы данных, указанной в конфигурации, если она не существует:
`php bin/console doctrine:database:create --if-not-exists`

## Генерация сущностей на основе существующей базы данных с аннотациями в формате простых PHP-классов и YAML:
`php bin/console doctrine:mapping:convert simple_yaml ./config/doctrine --from-database --extend`

## Удаление таблицы или таблиц из базы данных:
`php bin/console doctrine:schema:drop --force`

## Генерация классов сущностей на основе существующей базы данных с аннотациями в формате XML и YAML:
`php bin/console doctrine:mapping:convert xml_yaml ./config/doctrine --from-database --extend`

## Генерация SQL-скрипта для применения последних миграций:
`php bin/console doctrine:migrations:execute --up-to-date`

## Генерация SQL-скрипта для отката всех миграций:
`php bin/console doctrine:migrations:execute --down-to YYYYMMDDHHMMSS`

## Генерация SQL-скрипта для применения всех доступных миграций, включая уже выполненные:
`php bin/console doctrine:migrations:execute --all-or-nothing`

Doctrina в Symfony поддерживает различные флаги, которые можно использовать с командами для настройки и дополнительной функциональности. Вот некоторые из наиболее распространенных флагов Doctrina:
`--force или -f`: Флаг --force применяется для выполнения команд с подтверждением без запроса пользователю на подтверждение. Например, при использовании команды doctrine:schema:update, --force позволяет внести изменения в базу данных без подтверждения от пользователя.
`--no-interaction или -n`: Флаг --no-interaction используется для выполнения команд без взаимодействия с пользователем. Это полезно, когда требуется автоматизировать процесс выполнения команд в сценариях или скриптах.
`--dump-sql`: Флаг --dump-sql позволяет отобразить SQL-запросы, которые будут выполнены, но без их фактического выполнения. Это полезно для просмотра SQL-скриптов, которые будут применены при выполнении миграций или обновлении схемы базы данных.
`--dry-run`: Флаг --dry-run используется для выполнения команды в режиме "пробного запуска" или "тестового запуска". Он отображает результаты операции, но не вносит никаких изменений или не выполняет SQL-запросы. Это полезно для проверки результатов или диагностики перед фактическим выполнением операции.
`--env`: Флаг --env позволяет указать окружение, в котором должна выполняться команда. Например, --env=prod указывает Symfony выполнить команду в окружении "prod" (продакшн).
`--bundle или -b`: Флаг --bundle позволяет указать конкретный бандл (пакет) Symfony, к которому применяется команда. Например, при выполнении команды doctrine:generate:entity, флаг --bundle=AppBundle указывает, что сущность должна быть создана в бандле AppBundle.
`--filter` или -f: Флаг --filter используется с командой doctrine:generate:entities и позволяет указать фильтр для выбора конкретных сущностей, которые требуется сгенерировать. Например, --filter=User указывает, что только сущности с именем "User" должны быть сгенерированы.
`--em или --emid`: Флаг --em или --emid используется для указания имени менеджера сущностей (Entity Manager) при выполнении команд. Например, --em=default указывает, что команда должна использовать менеджер сущностей с именем "default".
`--namespace или -ns`: Флаг --namespace используется для указания пространства имён (namespace) для создаваемых классов или сущностей. Например, --namespace=App\\Entity указывает, что создаваемые классы должны быть помещены в пространство имён "App\Entity".
`--path`: Флаг --path используется для указания пути, по которому должны быть созданы или обновлены файлы конфигурации или метаданных. Например, --path=./config/doctrine указывает, что файлы конфигурации Doctrine должны быть созданы или обновлены в папке "config/doctrine".
`--to или --from`: Флаги --to или --from используются с командой doctrine:migrations:execute и позволяют указать версии миграций, до которых или от которых должна быть выполнена миграция. Например, --to=Version20230501120000 указывает, что миграция должна быть выполнена до версии "Version20230501120000".

